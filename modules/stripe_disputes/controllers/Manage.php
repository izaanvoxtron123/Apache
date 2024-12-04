<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Manage extends ClientsController
class Manage extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $starting_after = $this->input->get('starting_after');
        $disputes = $this->get_disputes($starting_after);
        $this->load->view('view', ['disputes' => $disputes]);
    }

    public function view($id)
    {
        try {
            $stripe_secret_key = $this->get_stripe_secret_key();
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            $dispute = $stripe->disputes->retrieve($id);
        } catch (Exception $e) {
            $dispute = null;
        }
        $this->load->view('details', ['dispute' => $dispute]);
    }

    public function add_evidence($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('session');
            $evidence = [];
            $files = [];

            foreach ($_POST as $key => $value) {
                if ($value) {
                    $evidence[$key] = $value;
                } else {
                    continue;
                }
            }

            foreach ($_FILES as $key => $value) {
                if (!empty($value['name']) && isset($value['name'])) {
                    $file_id =  $this->upload_file_to_stripe($value['tmp_name']);
                    if ($file_id) {
                        $files[$key] = $file_id;
                    } else {
                        continue;
                    }
                }
            }

            $evidence = array_merge($evidence, $files);
            try {
                if (count($evidence)) {
                    $stripe_secret_key = $this->get_stripe_secret_key();
                    $stripe = new \Stripe\StripeClient($stripe_secret_key);
                    $stripe->disputes->update(
                        $id,
                        ['evidence' => $evidence]
                    );

                    $this->session->set_flashdata('success', 'Successfully sent evidence');
                    return redirect(admin_url('stripe_disputes/manage/view/') . $id);
                } else {
                    $this->session->set_flashdata('error', 'No evidence was presented');
                    return redirect(admin_url('stripe_disputes/manage/add_evidence/') . $id);
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
                return redirect(admin_url('stripe_disputes/manage/add_evidence/') . $id);
            }

            return;
        } else {
            try {
                $stripe_secret_key = $this->get_stripe_secret_key();
                $stripe = new \Stripe\StripeClient($stripe_secret_key);
                $dispute = $stripe->disputes->retrieve($id);
            } catch (Exception $e) {
                $dispute = null;
            }
            $this->load->view('add', [
                'dispute' => $dispute
            ]);
            return;
        }
    }

    public function close($id)
    {
        try {
            $stripe_secret_key = $this->get_stripe_secret_key();
            $stripe = new \Stripe\StripeClient($stripe_secret_key);
            $dispute =  $stripe->disputes->close($id);
            echo json_encode([
                "status" => true,
                "message" => 'Dispute Closed'
            ]);
            return;
        } catch (Exception $e) {
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
            return;
        };
    }

    private function get_disputes($starting_after = null)
    {
        try {
            $stripe_secret_key = $this->get_stripe_secret_key();
            $stripe = new \Stripe\StripeClient($stripe_secret_key);

            $filters = ['limit' => 100];
            if ($starting_after) {
                $filters['starting_after'] = $starting_after;
            }
            $disputes =  $stripe->disputes->all($filters);
        } catch (Exception $e) {
            $disputes = [];
        }
        return $disputes;
    }

    private function upload_file_to_stripe($file)
    {
        $stripe_secret_key = $this->get_stripe_secret_key();
        $stripe = new \Stripe\StripeClient($stripe_secret_key);
        $fp = fopen($file, 'r');
        try {
            $file =  $stripe->files->create([
                'purpose' => 'dispute_evidence',
                'file' => $fp
            ]);
            $stripe->fileLinks->create([
                'file' => $file->id,
            ]);

            return $file->id;
        } catch (Exception $e) {
            return null;
        };
    }

    private function get_stripe_secret_key()
    {
        try {
            $private_key = $this->encryption->decrypt(get_option('paymentmethod_stripe_api_secret_key'));
        } catch (Exception $e) {
            $private_key = null;
        }
        return $private_key;
    }
}
