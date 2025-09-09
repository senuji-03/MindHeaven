<?php

session_start();

require_once '../config/config.php';
require_once '../core/autoload.php';
require_once '../core/Router.php';
require_once '../core/view.php';

$router = new Router();

$router->get('/ug', 'UGControl@index');
$router->get('/ug/appointment', 'UGControl@appointment');

$router->get('/counselor', 'COControl@index');  
$router->get('/counselor/dashboard', 'COControl@dashboard');
$router->get('/counselor/appointments', 'COControl@appointmentmgt');
$router->get('/counselor/calender', 'COControl@calender');
$router->get('/counselor/session-history', 'COControl@sessionHistory');


$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);