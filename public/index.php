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

$router->get('/counselor', 'COControl@index');  
$router->get('/counselor/dashboard', 'COControl@dashboard');
$router->get('/counselor/appointments', 'COControl@appointmentmgt');
$router->get('/counselor/calender', 'COControl@calender');
$router->get('/counselor/session-history', 'COControl@sessionHistory');

$router->get('/CallResponder', 'CallResponderControl@index');
$router->get('/CallSuccess', 'CallResponderControl@success');

$router->get('/DonationForm', 'DonorControl@DonationForm');
$router->get('/DonationSuccess', 'DonorControl@DonationSuccess');

$router->get('/EditPosts', 'ModeratorControl@edit');
$router->get('/FlaggedUsers', 'ModeratorControl@flagged');
$router->get('/ModeratorDashboard', 'ModeratorControl@ModeratorDashboard');
$router->get('/WarnForm', 'ModeratorControl@warn');

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);