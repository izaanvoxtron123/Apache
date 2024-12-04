<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'dynamic_forms')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dynamic_forms` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL ,
        `description` TEXT NULL DEFAULT NULL ,
        `status` BOOLEAN NOT NULL DEFAULT TRUE ,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL ,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;
    ');

    $CI->db->query("INSERT INTO '" . db_prefix() . "'dynamic_forms` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES (1, 'Sample Form', 'This is sample form with most available form fields for future use', '1', '2023-06-01 14:13:39', NULL)");
}

if (!$CI->db->table_exists(db_prefix() . 'dynamic_form_fields')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'dynamic_form_fields` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `form_id` INT NOT NULL ,
        `sequence` INT(5) UNSIGNED NULL DEFAULT NULL ,
        `label` VARCHAR(50) NOT NULL ,
        `description` TEXT NULL DEFAULT NULL ,
        `name` VARCHAR(50) NOT NULL ,
        `html_params` TEXT NULL DEFAULT NULL ,
        `classes` TEXT NULL DEFAULT NULL ,
        `id_tag` VARCHAR(50) NULL DEFAULT NULL ,
        `field_type` VARCHAR(50) NULL DEFAULT NULL ,
        `input_type` VARCHAR(50) NULL DEFAULT NULL ,
        `options` TEXT NULL DEFAULT NULL ,
        `status` BOOLEAN NOT NULL DEFAULT TRUE ,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL ,
        PRIMARY KEY (`id`), INDEX (`form_id`)) ENGINE = InnoDB;
    ');

    $CI->db->query("INSERT INTO '" . db_prefix() . "'dynamic_form_fields` (`id`, `form_id`, `sequence`, `label`, `description`, `name`, `html_params`, `classes`, `id_tag`, `field_type`, `input_type`, `options`, `status`, `created_at`, `updated_at`) VALUES
    (1, 1, 3, 'Dropwdown', 'Description Description Description ', 'dropdown', 'required', 'Classes Classes Classes ', 'Element ID', 'dropdown', 'text', '[{\r\n\"label\" : \"First Value\",\r\n\"value\" : \"first-value\",\r\n},\r\n{\r\n\"label\" : \"Second Value\",\r\n\"value\" : \"second-value\",\r\n},\r\n{\r\n\"label\" : \"Third Value\",\r\n\"value\" : \"third-value\",\r\n},]', 1, '2023-04-26 15:39:20', '2023-06-01 09:12:23'),
    (2, 1, 1, 'input', 'Description', 'input', 'required', 'Classes Classes Classes ', 'email', 'input', 'email', 'Options Options Options ', 1, '2023-04-27 11:38:25', '2023-06-01 09:12:23'),
    (3, 1, 4, 'Radio Button', 'Description Description Description ', 'radio-button', 'required', 'Classes Classes Classes ', 'Element ID', 'radio', 'text', '[{\r\n\"label\" : \"First Value\",\r\n\"value\" : \"first-value\",\r\n\"classes\" : \"first class\"\r\n},\r\n{\r\n\"label\" : \"Second Value\",\r\n\"value\" : \"second-value\",\r\n\"classes\" : \"second class\"\r\n},\r\n{\r\n\"label\" : \"Third Value\",\r\n\"value\" : \"third-value\",\r\n\"classes\" : \"third class\"\r\n},]', 1, '2023-04-26 15:39:20', '2023-06-01 09:12:23'),
    (4, 1, 2, 'TextArea', 'Description', 'textarea', 'required', 'Classes Classes Classes ', 'email', 'textarea', 'email', 'Options Options Options ', 1, '2023-04-27 11:38:25', '2023-06-01 09:12:23'),
    (5, 1, 5, 'CheckBox', 'Description Description Description ', 'checkbox', 'required', 'Classes Classes Classes ', 'Element ID', 'checkbox', 'text', '[{\r\n\"label\" : \"First Value\",\r\n\"value\" : \"first-value\",\r\n\"classes\" : \"first class\"\r\n},\r\n{\r\n\"label\" : \"Second Value\",\r\n\"value\" : \"second-value\",\r\n\"classes\" : \"second class\"\r\n},\r\n{\r\n\"label\" : \"Third Value\",\r\n\"value\" : \"third-value\",\r\n\"classes\" : \"third class\"\r\n},]', 1, '2023-04-26 15:39:20', '2023-06-01 09:12:23'),
    (6, 1, 1, 'File', 'File', 'single_file', 'required', 'Classes Classes Classes ', 'email', 'input', 'file', 'Options Options Options ', 1, '2023-04-27 11:38:25', '2023-06-01 09:12:23'),
    (7, 1, 1, 'Multiple File', 'File', 'multiple_files[]', 'required multiple', 'Classes Classes Classes ', 'email', 'input', 'file', 'Options Options Options ', 1, '2023-04-27 11:38:25', '2023-06-01 09:12:23')");
}

if (!$CI->db->table_exists(db_prefix() . 'briefs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'briefs` (
        `id` INT NOT NULL AUTO_INCREMENT, 
        `form_id` INT NOT NULL , 
        `lead_id` INT NOT NULL , 
        `label` VARCHAR(50) NOT NULL , 
        `value` TEXT NULL DEFAULT NULL , 
        `is_media` BOOLEAN NOT NULL DEFAULT FALSE , 
        `is_multiple` BOOLEAN NOT NULL DEFAULT FALSE , 
        `media_type` VARCHAR(50) NULL DEFAULT NULL , 
        `status` BOOLEAN NOT NULL DEFAULT TRUE ,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL ,
        PRIMARY KEY (`id`), INDEX (`form_id`), INDEX (`lead_id`)) ENGINE = InnoDB;
    ');
}

// $fp = fopen("application/views/admin/tables/harsham.php", "rw+");
// // Define the code block as a string


$code_block = file_get_contents(__DIR__ . '/brief_code.php');
// $code_block = 'harsham';

// Your code block here

// Get the contents of the PHP file
$file_contents = file_get_contents('application/views/admin/tables/leads.php');

// Split the contents into an array of lines
$file_lines = explode("\n", $file_contents);
$file_lines_injected_code = explode("\n", $code_block);

if (!count(array_intersect($file_lines, $file_lines_injected_code)) == count($file_lines_injected_code)) {
    // Insert the code block at line 133
    array_splice($file_lines, 133, 0, $code_block);

    // Join the lines back into a string
    $new_file_contents = implode("\n", $file_lines);

    // Write the new contents back to the PHP file
    file_put_contents('application/views/admin/tables/leads.php', $new_file_contents);
}
