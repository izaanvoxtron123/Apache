<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['api/token'] = 'Api/token';

$route['api/get/(:any)'] = 'Api/get/$1';
$route['api/post/(:any)']['post'] = 'Api/post/$1';
