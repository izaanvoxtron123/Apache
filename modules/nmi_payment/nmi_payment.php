<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Nmi Payment Gateway
Description: Ability to accept payments through NMI Payment Gateway.
Version: 1.2.2
Requires at least: 2.3.*

*/
define('NMI_GATEWAY_MODULE_NAME', 'nmi_payment');


register_activation_hook(NMI_GATEWAY_MODULE_NAME, 'nmi_payment_module_activation_hook');

function nmi_payment_module_activation_hook()
{
    require_once(__DIR__ . '/install.php');
}

register_deactivation_hook(NMI_GATEWAY_MODULE_NAME, 'nmi_payment_module_deactivation_hook');
function nmi_payment_module_deactivation_hook()
{
    require_once(__DIR__ . '/uninstall.php');
}
