<?php

defined('BASEPATH') or exit('No direct script access allowed');

// exit("DEACTIVATE");
$CI = &get_instance();
$filepath = './application/libraries/gateways/Nmi_gateway.php';
if (file_exists($filepath)) {
    unlink($filepath);
}
