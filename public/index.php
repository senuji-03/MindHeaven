<?php

session_start();

require_once '../config/config.php';
require_once '../core/autoload.php';
require_once '../core/Router.php';
require_once '../core/view.php';

$router = new Router();

$router->get('/ug', 'UGControl@index');
$router->get('/ug/appointment', 'UGControl@appointment');

$router->get('/admin', 'AdminControl@index'); // Admin dashboard
$router->get('/admin/manage-users', 'AdminControl@manageUsers');
$router->get('/admin/resource-hub', 'AdminControl@resourceHub');


$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);