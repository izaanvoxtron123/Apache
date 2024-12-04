<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Leads extends ClientsController
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('leads_model');
        $this->load->model('invoices_model');
    }

    public function createLead()
    {
        try {
            $request = $this->input->post();

            $ipAndInfo = $this->getInfo();

            $this->db->select('country_id');
            $this->db->where(['short_name' => $ipAndInfo['country']]);
            $country_record = $this->db->get('tblcountries')->row();
            $country_id = !empty($country_record) ? $country_record->country_id : 0;

            $leadData = [
                'name' => $request['name'],
                'address' => $request['address'],
                'email' => $request['email'],
                'phonenumber' => $request['phone'],
                "lead_value" => trim($request['price'], '$'),
                "website" => $request['page'],
                "city" => $ipAndInfo['city'] ?? "",
                "country" => $country_id,
                "state" => $ipAndInfo['region'] ?? "",
                "zip" => $ipAndInfo['postal_code'] ?? "",
                "ip" => $ipAndInfo['ip'] ?? "",
                "isp" => $ipAndInfo['organization'] ?? "",
                "description" => $request['message'],
                "source" => $request['referer'] == 'google' ? 1 : 2,
            ];
            $insert_id      = $this->leads_model->add($leadData);
            $leadData['lead_id'] = $insert_id;

            updateSalesViaEmail("New lead created", newLeadEmailTemplate($leadData));

            echo json_encode([
                "code" => 200,
                "status" => true,
                "error" => '',
                "message" => "Success",
                "data" => [
                    "lead_id" => $insert_id,
                ]
            ]);
            return;
        } catch (Exception $e) {
            echo json_encode([
                "code" => 500,
                "status" => false,
                "error" => $e->getMessage(),
            ]);
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            return;
        }
    }

    public function addBrief($lead_id)
    {
        try {
            $request = $this->input->post();
            $emailData = $this->input->post();
            $request = json_encode($request);
            $this->db->where('id', $lead_id);
            $updated = $this->db->update('tblleads', ["brief" => $request]);

            // UPLOAD IMAGES
            $this->load->library('upload');

            $config = array();
            $config['upload_path'] = FCPATH . '/uploads/leads';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = '0';
            $config['encrypt_name'] = TRUE;
            $config['overwrite']     = FALSE;

            $leadImages = array();
            $files = $_FILES;

            $cpt = isset($_FILES['image']['name']) ? count($_FILES['image']['name']) : 0;

            for ($i = 0; $i < $cpt; $i++) {
                $_FILES['image']['name'] = $files['image']['name'][$i];
                $_FILES['image']['type'] = $files['image']['type'][$i];
                $_FILES['image']['tmp_name'] = $files['image']['tmp_name'][$i];
                $_FILES['image']['error'] = $files['image']['error'][$i];
                $_FILES['image']['size'] = $files['image']['size'][$i];

                $this->upload->initialize($config);
                $this->upload->do_upload('image');
                $leadImages[$i]['lead_id'] = $lead_id;
                $leadImages[$i]['source'] = 'uploads/leads/' . $this->upload->data()['file_name'];
                $leadImages[$i]['status'] = 1;
            }
            $this->db->insert_batch('tblleads_images', $leadImages);

            // END UPLOAD IMAGES
            if ($updated) {

                $emailData['lead_id'] = $lead_id;
                updateSalesViaEmail("Brief added in lead", briefAddedInLeadEmailTemplate($emailData));

                echo json_encode([
                    "code" => 200,
                    "status" => true,
                    "error" => '',
                    "message" => "Success",
                    "data" => []
                ]);
                return;
            } else {
                throw new Exception;
            }
        } catch (Exception $e) {
            echo json_encode([
                "code" => 500,
                "status" => false,
                "error" => $e->getMessage(),
            ]);
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            return;
        }
    }

    public function UpdateBrief($lead_id)
    {
        try {
            $request = $this->input->post();

            $lead = $this->leads_model->get($lead_id);
            $brief = isset($lead->brief) ? json_decode($lead->brief, true) : [];
            $brief['Package'] = $request['Package'];
            $brief['Price'] = $request['Price'];
            $brief['Trademark_Search_Type'] = $request['Trademark_Search_Type'];
            $brief['Expedite_Process'] = $request['Expedite_Process'];
            $brief = json_encode($brief);

            $updated = $this->db->update('tblleads', ["brief" => $brief]);
            if ($updated) {

                echo json_encode([
                    "code" => 200,
                    "status" => true,
                    "error" => '',
                    "message" => "Success",
                    "data" => []
                ]);
                return;
            } else {
                throw new Exception;
            }
        } catch (Exception $e) {
            echo json_encode([
                "code" => 500,
                "status" => false,
                "error" => $e->getMessage(),
            ]);
        }
    }

    public function paid($lead_id)
    {
        try {
            $lead = $this->leads_model->get($lead_id);
            $transaction_id = $this->input->get('transaction_id');

            // echo "<pre>";
            // print_r($lead);
            // return;

            // FIND IF CLIENT IS ALREADY REGISTERED
            $this->load->model('clients_model');
            $already_customer = $this->clients_model->get('', ['email' => $lead->email]);

            if (!count($already_customer)) {
                $data = [
                    'leadid' => $lead_id,
                    'firstname' => explode(' ', $lead->name)[0],
                    'lastname' => explode(' ', $lead->name)[1] ?  explode(' ', $lead->name)[1] :  '',
                    'email' => $lead->email,
                    'phonenumber' => $lead->phonenumber,
                    'company' => $lead->company ? $lead->company : 'N/A',
                    'website' => $lead->website,
                    'city' => $lead->city,
                    'state' => $lead->state,
                    'zip' => $lead->zip,
                    'original_lead_email' => $lead->email,
                    'country' => $lead->country,
                    'default_language' => '',
                    'title' => '',
                    'address' => '',
                    'fakeusernameremembered' => '',
                    'fakepasswordremembered' => 'Admin@123',
                    'password' => '',
                    'send_set_password_email' => 'on',
                ];

                $converted = $this->leads_model->convert_to_customer($data);
            } else {
                $this->db->update('tblleads', [
                    "client_id" => $already_customer[0]['userid']
                ]);
                $converted['status'] = true;
                $converted['id'] = $already_customer[0]['userid'];
            }

            if ($converted['status']) {


                $brief = $lead ? $lead->brief : json_encode([]);
                $brief =  json_decode($brief);
                $price = $brief->Price ? filter_var($brief->Price, FILTER_SANITIZE_NUMBER_INT) : 0;


                $query = $this->db->query("SELECT * FROM `tblinvoices` ORDER BY `id` DESC LIMIT 1");
                $last_invoice = $query->row();
                $invoice_number = isset($last_invoice) ? $last_invoice->number + 1 : 1;

                // CREATE INVOICE 
                $this->db->insert('tblinvoices', [
                    'prefix' => 'INV-',
                    'clientid' => $converted['id'],
                    'number' => $invoice_number,
                    'datecreated' => date('Y-m-d H:i:s'),
                    'date' => date('Y-m-d'),
                    'currency' => '1',
                    'subtotal' => $price,
                    'total_tax' => 0,
                    'total' => $price,
                    'adjustment' => 0.00,
                    'addedfrom' => 1,
                    'number_format' => 1,
                    'status' => 2,
                    'billing_city' => $lead->city,
                    'billing_state' => $lead->state,
                    'billing_zip' => $lead->zip,
                    'billing_country' => $lead->country,
                ]);
                $invoice_id =  $this->db->insert_id();

                // ADD INVOICE ITEM
                $this->db->insert('tblitemable', [
                    'rel_id' => $invoice_id,
                    'rate' => $price,
                    'rel_type' => 'invoice',
                    'qty' => 1.00,
                    'item_order' => 1,
                ]);

                // ADD PAYMENT RECORD
                $this->db->insert('tblinvoicepaymentrecords', [
                    'invoiceid' => $invoice_id,
                    'amount' => $price,
                    'paymentmode' => 'stripe',
                    'date' => date('Y-m-d'),
                    'daterecorded' => date('Y-m-d H:i:s'),
                    'transactionid' => $transaction_id
                ]);
                randomizeMerchant();
                $this->invoices_model->send_invoice_to_client(
                    $invoice_id,
                    '',
                    true,
                    '',
                    true
                );
                echo json_encode([
                    "code" => 200,
                    "status" => true,
                    "error" => '',
                    "message" => "Success",
                    "data" => []
                ]);
            } else {
                throw new Exception;
            }
        } catch (Exception $e) {
            echo json_encode([
                "code" => 500,
                "status" => false,
                "error" => $e->getMessage(),
            ]);
        }
    }

    // set IP address and API access key
    function getInfo()
    {

        $ip = $this->getUserIpAddr();

        $url = "https://ip.seeip.org/geoip/" . $ip;
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($result, true);
        return $api_result;
    }

    function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
