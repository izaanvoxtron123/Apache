<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inquiries_model extends App_Model
{
    protected $table_name = 'tblinquiries';
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        try {
            $query = $this->db->insert($this->table_name, $data);
            return [
                "status" =>   $query ? true : false
            ];
        } catch (Exception $e) {
            return ['status' => false];
        }
    }
    
    public function get($id = null)
    {
        try {
            if ($id) {
                $this->db->where('id', $id);
                $query = $this->db->get($this->table_name);
                return $query->row();
            } else {
                $query = $this->db->get($this->table_name);
                return $query->result_array();
            }
        } catch (Exception $e) {
            return  false;
        }
    }
}
