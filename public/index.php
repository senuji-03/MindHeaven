<?php

session_start();

require_once '../config/config.php';
require_once '../core/autoload.php';
require_once '../core/Router.php';
require_once '../core/view.php';

$router = new Router();

$router->get('/ug', 'UGControl@index');
$router->get('/ug/appointment', 'UGControl@appointment');
$router->get('/ug/contact', 'UGControl@contact');
$router->get('/ug/crisis', 'UGControl@crisis');
$router->get('/ug/habits', 'UGControl@habits');
$router->get('/ug/resources', 'UGControl@resources');
$router->get('/ug/mood', 'UGControl@mood');

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);