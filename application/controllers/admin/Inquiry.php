<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inquiry extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inquiries_model');
    }

    public function index()
    {
        $data['results']     = $this->Inquiries_model->get();
        $this->load->view('admin/inquiry/view', $data);
        return;
    }
}
