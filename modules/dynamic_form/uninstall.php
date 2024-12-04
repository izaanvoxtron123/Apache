<?php

defined('BASEPATH') or exit('No direct script access allowed');
$code_block = file_get_contents(__DIR__ . '/brief_code.php');
$code_blocks = explode("\n", $code_block);


// // Get the contents of the PHP file

if (count($code_blocks)) {
    $file_contents = file_get_contents('application/views/admin/tables/leads.php');

    $file_lines = explode("\n", $file_contents);

    
    foreach ($code_blocks as $key => $block) {
        $without_space_block = str_replace(" ", "", $block);
        if (strlen($without_space_block) > 1) {
            $file_contents = str_replace($block, '', $file_contents);
        }
    }
}

file_put_contents('application/views/admin/tables/leads.php', $file_contents);

