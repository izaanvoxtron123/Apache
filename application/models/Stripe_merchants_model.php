<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stripe_merchants_model extends App_Model
{
    protected $table_name = 'tblstripe_merchants';

    public function __construct()
    {
        parent::__construct();
    }

    public function add($inputData)
    {
        try {
            $data = [
                'publishable_key' => $inputData['publishable_key'],
                'secret_key' => $this->encryption->encrypt($inputData['secret_key']),
                // 'is_active' => $inputData['is_active'],
                'status' => $inputData['status'],
            ];
            $query = $this->db->insert($this->table_name, $data);
            return [
                "id" => $this->db->insert_id(),
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

    public function edit($id, $inputData)
    {
        try {
            $data = [
                'publishable_key' => $inputData['publishable_key'],
                'secret_key' => $this->encryption->encrypt($inputData['secret_key']),
                // 'is_active' => $inputData['is_active'],
                'status' => $inputData['status'],
            ];
            $this->db->where('id', $id);
            $query = $this->db->update($this->table_name, $data);
            return [
                "id" => $this->db->insert_id(),
                "status" =>   $query ? true : false
            ];
        } catch (Exception $e) {
            return ['status' => false];
        }
    }
}
