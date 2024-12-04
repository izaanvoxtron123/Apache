<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment_methods extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->table_name = db_prefix() . 'payment_methods';
    }
    private $table_name;

    public function add($client_id, $card_number, $card_type, $ending_with, $expiry, $cvv, $cardname)
    {
        return $this->db->insert($this->table_name, [
            'clientid' => $client_id,
            'card_number' => $this->encryption->encrypt($card_number),
            'ending_with' => $ending_with,
            'expiry' => $expiry,
            'cvv' => $cvv,
            'card_type' => $card_type,
            'card_name' => $cardname,
        ]);
    }

    public function get($client_id)
    {
        $this->db->select();
        $this->db->from($this->table_name);
        $this->db->where('clientid', $client_id);
        return $this->db->get()->result_array();
    }

    public function get_card_info($card_id)
    {
        $this->db->select();
        $this->db->from($this->table_name);
        $this->db->where('id', $card_id);
        $result = $this->db->get()->row();

        $result->card_number = $this->encryption->decrypt($result->card_number);

        return $result;
    }
}
