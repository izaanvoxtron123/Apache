<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Revenue extends ClientsController
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('invoices_model');

        $CI = &get_instance();
        $CI->load->helper('email');
    }

    public function get()
    {
        try {
            if (!$this->validateToken()) {
                echo json_encode([
                    "code" => 401,
                    "status" => false,
                    "error" => "Unauthenticated access",
                ]);
                return;
            }

            $request = $this->input->post();
            $start_date = $request['start_date'] ?? '';
            $end_date = $request['end_date'] ?? '';

            $response = $this->invoices_model->getRevenue($start_date, $end_date);
   
            echo json_encode([
                "code" => 200,
                "status" => true,
                "error" => '',
                "message" => "Success",
                "data" => $response['data']
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
}
