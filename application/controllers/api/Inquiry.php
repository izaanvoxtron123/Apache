<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inquiry extends ClientsController
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('inquiries_model');
        
        $CI =& get_instance();
        $CI->load->helper('email');
    }

    public function create()
    {
        try {
            $request = $this->input->post();

            $data = [
                "name" => $request['name'],
                "email" => $request['email'],
                "message" => $request['message'],
            ];

            $response = $this->inquiries_model->create($data);
            if ($response['status']) {

                updateSalesViaEmail("New Contact Inquiry",  $request['message']);

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
}
