<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dynamic_forms extends App_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = db_prefix(). 'dynamic_forms';
    }
    private $table_name ;

    public function get($id = null)
    {
        $this->db->select();
        $this->db->from($this->table_name);
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->get()->row();
        }
        return $this->db->get()->result_array();
        // return $this->db->row();
    }

    public function add($data)
    {
        return $this->db->insert($this->table_name, $data);
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table_name, $data);
    }
}
