<?php

defined('BASEPATH') or exit('No direct script access allowed');

// exit("ACTIVATE");
$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'payment_methods')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'payment_methods` (
        `id` INT NOT NULL AUTO_INCREMENT, 
        `clientid` INT NOT NULL , 
        `card_number` VARCHAR(500) NOT NULL , 
        `card_name` VARCHAR(300) NOT NULL , 
        `ending_with` VARCHAR(10) NOT NULL , 
        `expiry` VARCHAR(10) NOT NULL , 
        `cvv` VARCHAR(300) NOT NULL , 
        `card_type` VARCHAR(10) NULL DEFAULT NULL , 
        `status` BOOLEAN NOT NULL DEFAULT TRUE ,
        `crated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL ,
        PRIMARY KEY (`id`), INDEX (`clientid`)) ENGINE = InnoDB;
    ');
}

if (!$CI->db->table_exists(db_prefix() . 'payment_error_logs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'payment_error_logs` (
        `id` INT NOT NULL AUTO_INCREMENT, 
        `clientid` INT NOT NULL , 
        `invoice_id` INT NOT NULL , 
        `error_code` VARCHAR(50) NOT NULL , 
        `ref_id` VARCHAR(300) NOT NULL , 
        `response_text` TEXT NULL , 
        `response` TEXT NULL , 
        `crated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL ,
        PRIMARY KEY (`id`), INDEX (`invoice_id`), INDEX (`clientid`)) ENGINE = InnoDB;
    ');
}




$filepath = './application/libraries/gateways/Nmi_gateway.php';
if (!file_exists($filepath)) {
    $file_to_write = fopen($filepath, 'w');
    $sample_file = file_get_contents(__DIR__.'/Nmi_gateway_sample.php');
    file_put_contents($filepath, $sample_file);
}
