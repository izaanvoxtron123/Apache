<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Brief Forms
Description: Create form with desired fields to use later as lead's brief form.
Version: 1.1
Requires at least: 2.3.*
*/
define('DYNAMIC_FORM_MODULE_NAME', 'dynamic_form');

hooks()->add_action('admin_init', 'dynamic_form_init_menu_items');

register_activation_hook(DYNAMIC_FORM_MODULE_NAME, 'dynamic_form_module_activation_hook');
register_deactivation_hook(DYNAMIC_FORM_MODULE_NAME, 'dynamic_form_module_deactivation_hook');

function dynamic_form_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

function dynamic_form_module_deactivation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/uninstall.php');
}



function dynamic_form_init_menu_items()
{
    /**
     * If the logged in user is administrator, add custom menu in Setup
     */
    if (is_admin()) {
        $CI = &get_instance();
        $CI->app_menu->add_sidebar_menu_item('dynamic-form', [
            'name'     => 'Brief Forms',
            'href'     => admin_url('dynamic_form/manage'),
            'position' => 22,
            'icon'     => 'fa fa-wpforms',
            'badge'    => [],
        ]);
    }
}
