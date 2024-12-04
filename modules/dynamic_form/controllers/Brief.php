<?php


defined('BASEPATH') or exit('No direct script access allowed');
define('SITE_ROOT', realpath(dirname(__FILE__)));

class Brief extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('briefs');
    }

    public function view($lead_id)
    {
        $response['briefs'] = $this->briefs->get($lead_id);
        $this->load->view('brief/view', $response);
        // echo "<pre>";
        // print_r($data);
        return;
    }
}
