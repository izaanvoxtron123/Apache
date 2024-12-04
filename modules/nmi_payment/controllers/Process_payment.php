<?php

class Process_Payment extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('payment_methods');
        $this->load->model('payment_error_logs');
    }

    public function index()
    {
        $CI = &get_instance();
        $this->load->model('invoices_model');
        $this->load->model('clients_model');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $invoice_id = $this->input->post('invoice_id');
            $amount_to_charge = $this->input->post('amount');
            $invoice = $CI->invoices_model->get($invoice_id);

            $invoice_number = format_invoice_number($invoice_id);

            $status = $this->get_invoice_payment_status($amount_to_charge, $invoice);

            $nmi = new Nmi_gateway;
            // $nmi->setLogin(get_option('paymentmethod_nmi_login_key'));
            $nmi_username = get_option('paymentmethod_nmi_username');
            $nmi_password = get_option('paymentmethod_nmi_password');
            $nmi->setLogin($nmi_username, $this->encryption->decrypt($nmi_password));

            $nmi->setBilling(
                $this->input->post('firstname'),
                $this->input->post('lastname'),
                $invoice->client->company,
                $invoice->client->billing_street,
                // "Suite 200",
                $invoice->client->billing_city,
                $invoice->client->billing_state,
                $this->input->post('zip'),
                $this->input->post('billing_country'),
                $this->input->post('phonenumber'),
                // "555-555-5556",
                $this->input->post('email'),
                $invoice->client->website,
            );
            $nmi->setOrder(
                $invoice_number,
                "Invoice sale of " . $invoice_number,
                0,
                0,
                "",
                ""
            );

            $r = $nmi->doSale(
                $amount_to_charge,
                str_replace(' ', '', $this->input->post('cardnumber')),
                str_replace('/', '', $this->input->post('exp')),
                // $this->input->post('expmonth') . $this->input->post('expyear'),
                $this->input->post('cvv'),
            );
            $response = $nmi->responses;

            // echo "<pre>";
            // print_r($response);
            // return;
            if ($response['response'] == "1") {
                // MARK INVOICE AS PAID
                $this->db->update('tblinvoices', ['status ' => $status], ['id' => $invoice_id]);

                // ADD PAYMENT RECORD`
                $this->db->insert('tblinvoicepaymentrecords', [
                    'invoiceid' => $invoice_id,
                    'amount' => $amount_to_charge,
                    'paymentmode' => 'nmi',
                    'date' => date('Y-m-d'),
                    'daterecorded' => date('Y-m-d H:i:s'),
                    'transactionid' => $response['transactionid']
                ]);

                // Save Card if it is unique
                if ($this->is_card_unique($invoice->clientid, str_replace(' ', '', $this->input->post('cardnumber')))) {
                    $this->save_card(
                        $invoice->clientid,
                        $this->input->post('cardnumber'),
                        str_replace('/', '', $this->input->post('exp')),
                        $this->input->post('cvv'),
                        $this->input->post('cardname'),

                    );
                }
                $redirection_url = site_url('invoice/' . $invoice_id . '/' . $invoice->hash);
                if ($this->input->post('ajax_call')) {
                    echo json_encode([
                        'status' => true,
                        'redirection_url' => $redirection_url,
                    ]);
                } else {
                    set_alert('success', "Transaction Successful");
                    return redirect($redirection_url);
                }
            } else {
                // ADD LOG FOR ERROR 
                $this->payment_error_logs->add(
                    $invoice->clientid,
                    $invoice->id,
                    $response['response_code'],
                    $response['transactionid'],
                    $response['responsetext'],
                    $response
                );
                if ($this->input->post('ajax_call')) {
                    set_alert('success', "Transaction Successful");
                    echo json_encode([
                        'status' => false,
                        "code" => $response['response_code'],
                        "message" => $response['responsetext'],
                        "data" => json_encode($this->input->post())
                    ]);
                } else {
                    $this->session->set_flashdata('nmi_cc_error', [
                        "code" => $response['response_code'],
                        "message" => $response['responsetext'],
                        "data" => json_encode($this->input->post())
                    ]);
                    // echo "<pre>";
                    // print_r($this->session->flashdata('nmi_cc_error'));
                    // return;
                    $this->load->library('user_agent');
                    redirect($this->agent->referrer());
                    return;
                    if ($this->agent->is_referral()) {
                    } else {
                        set_alert('danger', $response['responsetext']);
                        return redirect(site_url('invoice/' . $invoice_id . '/' . $invoice->hash));
                    }
                }
            }
        } else {
            $invoice_data = json_decode(base64_decode($this->input->get('invoice')));

            if (!isset($invoice_data) || empty($invoice_data) || !$invoice_data) {
                redirect(site_url('nmi_payment/process_payment/invalid_invoice'));
                return;
            }

            $invoice_number = format_invoice_number($invoice_data->invoiceid);

            if (!isset($invoice_number) || empty($invoice_number) || !$invoice_number) {
                redirect(site_url('nmi_payment/process_payment/invalid_invoice'));
                return;
            }

            $company_name = get_option('companyname');
            $company_logo = get_option('favicon');


            $invoice =  $CI->invoices_model->get($invoice_data->invoiceid);
            $data['invoice'] = gettype($invoice) == "array" ? (object)$invoice[0] : $invoice;

            $client_existing_cards = $this->payment_methods->get($data['invoice']->clientid);

            $data['amount'] = $invoice_data->amount;
            $data['invoice_number'] = $invoice_number;
            $data['company_name'] = $company_name;
            $data['company_logo'] = $company_logo;
            $data['client_existing_cards'] = $client_existing_cards;

            return $this->load->view('nmi_form', $data);
        }
    }

    public function get_card_info($card_id)
    {
        $result = $this->payment_methods->get_card_info($card_id);
        $status = $result ? true : false;
        echo json_encode([
            "status" => $status,
            "data" => $result
        ]);
    }

    private function save_card($client_id, $card_number, $expiry, $cvv, $cardname)
    {
        $card_type = $this->get_card_type($card_number);
        $ending_with = $this->get_card_ending($card_number);

        $this->payment_methods->add($client_id, str_replace(' ', '', $card_number), $card_type, $ending_with, $expiry, $cvv, $cardname);
    }

    private function get_card_type($card_number)
    {
        $first_digit = $card_number[0];
        $card_type = '';
        switch ($first_digit) {
            case 2:
                $card_type = "mastercard";
                break;
            case 3:
                $card_type = "amex";
                break;
            case 4:
                $card_type = "visa";
                break;
            case 5:
                $card_type = "mastercard";
                break;
            default:
                $card_type = "other";
                break;
        }
        return $card_type;
    }

    private function get_card_ending($card_number)
    {
        $ending_with = substr($card_number, -4);
        return $ending_with;
    }

    private function is_card_unique($client_id, $card_number)
    {
        $client_existing_cards = $this->payment_methods->get($client_id);
        $card_numbers = [];
        if (count($client_existing_cards) > 0) {
            foreach ($client_existing_cards as $key => $card) {
                $card_numbers[$key] = $this->encryption->decrypt($card['card_number']);
            }

            if (in_array($card_number, $card_numbers)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function invalid_invoice()
    {
        return $this->load->view('invalid_invoice', [
            'heading' => 'Invalid Invoice Details',
            'message' => 'Invoice details are invalid please contact support.',
        ]);
    }

    public function get_invoice_payment_status($amount, $invoice)
    {
        $fully_paid = 2;
        $partially_paid = 3;
        if (count($invoice->payments)) {

            $total_paid =  array_sum(array_column($invoice->payments, 'amount'));
            if (($total_paid + $amount) == $invoice->total) {
                return $fully_paid;
            } else {
                return $partially_paid;
            }
        } else {
            if ($amount == $invoice->total) {
                return $fully_paid;
            } else {
                return $partially_paid;
            }
        }
    }
}
