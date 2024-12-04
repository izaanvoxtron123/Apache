<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Briefs extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = db_prefix() . 'briefs';
    }
    private $table_name;


    public function get($lead_id = null)
    {
        $this->db->select();
        $this->db->from($this->table_name);
        $this->db->where('lead_id', $lead_id);
        return $this->db->get()->result_array();
        // return $this->db->row();
    }

    public function add($data)
    {
        return $this->db->insert_batch($this->table_name, $data);
    }
}
