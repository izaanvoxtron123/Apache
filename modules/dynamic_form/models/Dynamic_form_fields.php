<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dynamic_form_fields extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = db_prefix() . 'dynamic_form_fields';
    }
    private $table_name;



    public function get($form_id, $id = null)
    {
        $this->db->select();
        $this->db->from($this->table_name);
        $this->db->where('form_id', $form_id);
        $this->db->order_by('sequence');
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

    public function update_sequence($id, $sequence)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table_name, ['sequence' => $sequence]);
    }
}
