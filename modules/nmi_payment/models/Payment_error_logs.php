<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment_error_logs extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = db_prefix() . 'payment_error_logs';
    }
    private $table_name;

    public function add($client_id, $invoice_id, $error_code, $ref_id, $response_text, $response)
    {
        return $this->db->insert($this->table_name, [
            'clientid' => $client_id,
            'invoice_id' => $invoice_id,
            'error_code' => $error_code,
            'ref_id' => $ref_id,
            'response_text' => $response_text,
            'response' => json_encode($response)
        ]);
    }
}
