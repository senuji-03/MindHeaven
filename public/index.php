<?php

session_start();

require_once '../config/config.php';
require_once '../core/autoload.php';
require_once '../core/Router.php';
require_once '../core/view.php';

$router = new Router();

$router->get('/', 'LandingControl@index');
$router->get('/landing', 'LandingControl@index');

$router->get('/login', 'LoginControl@index'); 
$router->post('/login/authenticate', 'LoginControl@authenticate'); 
$router->get('/logout', 'LoginControl@logout');

// Signup routes
$router->get('/signup', 'SignupControl@index');
$router->post('/signup/register', 'SignupControl@register');



$router->get('/ug', 'UGControl@index');
$router->get('/ug/appointment', 'UGControl@appointment');
$router->get('/ug/contact', 'UGControl@contact');
$router->get('/ug/crisis', 'UGControl@crisis');
$router->get('/ug/habits', 'UGControl@habits');
$router->get('/ug/resources', 'UGControl@resources');
$router->get('/ug/mood', 'UGControl@mood');
$router->get('/ug/about', 'UGControl@about');
$router->get('/ug/forum', 'UGControl@forum');
$router->get('/ug/quiz', 'UGControl@quiz');

$router->get('/admin', 'AdminControl@index'); // Admin dashboard
$router->get('/admin/manage-users', 'AdminControl@manageUsers');
$router->get('/admin/resource-hub', 'AdminControl@resourceHub');
$router->get('/admin/moderate-forum', 'AdminControl@moderateForum');
$router->get('/admin/counselors', 'AdminControl@counselors');
$router->get('/admin/appointments', 'AdminControl@appointments');
$router->get('/admin/approve-counselors', 'AdminControl@approveCounselors');
$router->get('/admin/reports', 'AdminControl@reports');
$router->get('/admin/donations', 'AdminControl@donations');
$router->get('/admin/awareness', 'AdminControl@awareness');
$router->get('/admin/monitoring', 'AdminControl@monitoring');
$router->get('/admin/settings', 'AdminControl@settings');
$router->get('/admin/profile', 'AdminControl@profile');

$router->get('/counselor', 'COControl@index');  
$router->get('/counselor/dashboard', 'COControl@dashboard');
$router->get('/counselor/appointments', 'COControl@appointmentmgt');
$router->get('/counselor/calender', 'COControl@calender');
$router->get('/counselor/session-history', 'COControl@sessionHistory');

$router->get('/CallResponder', 'CallResponderControl@index');
$router->get('/CallSuccess', 'CallResponderControl@success');

$router->get('/donation', 'DonationControl@index');
$router->post('/donation/submit', 'DonationControl@submit');

$router->get('/DonationForm', 'DonorControl@DonationForm');
$router->get('/DonationSuccess', 'DonorControl@DonationSuccess');

$router->get('/EditPosts', 'ModeratorControl@edit');
$router->get('/FlaggedUsers', 'ModeratorControl@flagged');
$router->get('/ModeratorDashboard', 'ModeratorControl@ModeratorDashboard');
$router->get('/WarnForm', 'ModeratorControl@warn');

$router->get('UniversityRepresentative/dashboard', 'UniversityRepresentativeControl@index');
$router->get('UniversityRepresentative/uploadImage', 'UniversityRepresentativeControl@uploadImage');
$router->post('UniversityRepresentative/handleUpload', 'UniversityRepresentativeControl@handleUpload');
$router->get('UniversityRepresentative/contactModerator', 'UniversityRepresentativeControl@contactModerator');

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);