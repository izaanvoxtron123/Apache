<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Stripe Disputes
Description: Module to manage all disputes with current Stripe Account.
Version: 0.0.1
Requires at least: 0.0.1.*

*/
define('STRIPE_DISPUTES_MODULE_NAME', 'stripe_disputes');


hooks()->add_action('admin_init', 'stripe_disputes_init_menu_items');

register_activation_hook(STRIPE_DISPUTES_MODULE_NAME, 'stripe_disputes_module_activation_hook');

function stripe_disputes_module_activation_hook()
{
    require_once(__DIR__ . '/install.php');
}

register_deactivation_hook(STRIPE_DISPUTES_MODULE_NAME, 'stripe_disputes_module_deactivation_hook');
function stripe_disputes_module_deactivation_hook()
{
    require_once(__DIR__ . '/uninstall.php');
}

function stripe_disputes_init_menu_items()
{
    /**
     * If the logged in user is administrator, add custom menu in Setup
     */
    if (is_admin()) {
        $CI = &get_instance();
        $CI->app_menu->add_sidebar_menu_item('stripe-disputes', [
            'name'     => 'Stripe Disputes',
            'href'     => admin_url('stripe_disputes/manage'),
            // 'href'     => 'asdasdasda',
            'position' => 23,
            'icon'     => 'fa fa-gavel',
            'badge'    => [],
        ]);
    }
}
