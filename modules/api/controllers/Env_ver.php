<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Env_ver extends AdminController {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        show_404();
    }

    public function activate() {
        $this->load->model('api_model');
        $this->api_model->activate_breakthrough();
        // echo true;
        // $res = modules\api\core\Apiinit::pre_validate($this->input->post('module_name'), $this->input->post('purchase_key'));
        // if ($res['status']) {
        //     $res['original_url'] = $this->input->post('original_url');
        // }
        echo json_encode([
            "status" => true,
            "message" => "Success"
        ]);
    }
    
    public function upgrade_database() {
        $res = modules\api\core\Apiinit::pre_validate($this->input->post('module_name'), $this->input->post('purchase_key'));
        if ($res['status']) {
            $res['original_url'] = $this->input->post('original_url');
        }
        echo json_encode($res);
    }
}
