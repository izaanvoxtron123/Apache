<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Manage_fields extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('dynamic_form_fields');
    }

    public function view($form_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                foreach ($_POST['sequence'] as $key => $id) {
                    $sequence = $key + 1;
                    $this->dynamic_form_fields->update_sequence($id, $sequence);
                }
                set_alert('success', 'Successfully updated');
                return true;
            } catch (Exception $e) {
                set_alert('danger', 'Something went wrong');
            }
        } else {
            $response = $this->dynamic_form_fields->get($form_id);
            $data = [
                'data' => $response,
                'form_id' => $form_id
            ];
            $this->load->view('fields/view', $data);
        }
    }

    public function add($form_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');

            $validation_rules = [
                [
                    'field' => 'label',
                    'label' => 'Label',
                    'rules' => 'required|max_length[49]'
                ],
                [
                    'field' => 'field_type',
                    'label' => 'Field Type',
                    'rules' => 'required'
                ],
                [
                    'field' => 'input_type',
                    'label' => 'Input Type',
                    'rules' => 'required'
                ],
                [
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required|max_length[49]'
                ],
            ];

            $this->form_validation->set_rules($validation_rules);
            if ($this->form_validation->run() == FALSE) {
                $data =   [
                    'form_id' => $form_id,
                    'id' => null,
                ];
                return $this->load->view('fields/form', $data);
            }
            $_POST['form_id'] = $form_id;
            $response =   $this->dynamic_form_fields->add($_POST);
            if ($response) {
                set_alert('success', "Form Field Added Successfully");
            } else {
                set_alert('danger', "Error! Something went wrong");
            }

            redirect(admin_url('dynamic_form/manage_fields/view/') . $form_id);
        } else {
            $data =   [
                'form_id' => $form_id,
                'id' => null,
            ];
            $this->load->view('fields/form', $data);
        }
    }

    public function edit($form_id, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->load->library('form_validation');

            $validation_rules = [
                [
                    'field' => 'label',
                    'label' => 'Label',
                    'rules' => 'required|max_length[49]'
                ],
                [
                    'field' => 'field_type',
                    'label' => 'Field Type',
                    'rules' => 'required'
                ],
                [
                    'field' => 'input_type',
                    'label' => 'Input Type',
                    'rules' => 'required'
                ],
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

            $_POST['form_id'] = $form_id;

            $response =   $this->dynamic_form_fields->edit($id, $_POST);
            if ($response) {
                set_alert('success', "Form Field Updated Successfully");
            } else {
                set_alert('danger', "Error! Something went wrong");
            }

            redirect(admin_url('dynamic_form/manage_fields/view/') . $form_id);
        } else {
            $response = $this->dynamic_form_fields->get($form_id, $id);

            $data =   [
                'form_id' => $form_id,
                'data' => $response,
                'id' => $id,
            ];
            $this->load->view('fields/form', $data);
        }
    }
}
