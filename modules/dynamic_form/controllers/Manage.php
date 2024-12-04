<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('dynamic_forms');
    }
    
    public function index()
    {
        $response = $this->dynamic_forms->get();
        $this->load->view('view', ['data' => $response]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');

            $validation_rules = [
                [
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required|max_length[49]'
                ],
            ];

            $this->form_validation->set_rules($validation_rules);
            if ($this->form_validation->run() == FALSE) {
                return $this->load->view('add');
            }

            $response =   $this->dynamic_forms->add($_POST);
            if ($response) {
                set_alert('success', "Dynamic Form Added Successfully");
            } else {
                set_alert('danger', "Error! Something went wrong");
            }

            redirect(admin_url('dynamic_form/manage'));
        } else {
            $this->load->view('add');
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');

            $validation_rules = [
                [
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required|max_length[49]'
                ],
            ];

            $this->form_validation->set_rules($validation_rules);
            if ($this->form_validation->run() == FALSE) {
                return $this->load->view('add');
            }

            $response =   $this->dynamic_forms->edit($id,$_POST);
            if ($response) {
                set_alert('success', "Dynamic Form Updated Successfully");
            } else {
                set_alert('danger', "Error! Something went wrong");
            }

            redirect(admin_url('dynamic_form/manage'));
        } else {
            $response = $this->dynamic_forms->get($id);
            $this->load->view('edit', ['data' => $response]);
        }
    }
}
