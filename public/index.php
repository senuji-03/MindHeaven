<?php

session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/autoload.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/view.php';

$router = new Router();

$router->get('/', 'LandingControl@index');
$router->get('/landing', 'LandingControl@index');

$router->get('/login', 'LoginControl@index'); 
$router->post('/login/authenticate', 'LoginControl@authenticate');
$router->get('/login/forgot-password', 'LoginControl@forgotPassword');
$router->post('/login/forgot-password', 'LoginControl@processForgotPassword');
$router->get('/login/reset-password', 'LoginControl@resetPassword');
$router->post('/login/reset-password', 'LoginControl@resetPassword'); 
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
$router->get('/ug/category-resources', 'UGControl@categoryResources');
$router->get('/ug/mood', 'UGControl@mood');
$router->get('/ug/about', 'UGControl@about');
$router->get('/ug/forum', 'UGControl@forum');
$router->get('/ug/quiz', 'UGControl@quiz');
$router->get('/ug/profile', 'UGControl@profile');
$router->get('/ug/profile/complete', 'UGControl@completeProfile');
$router->post('/ug/profile/complete', 'UGControl@completeProfile');
$router->get('/ug/feedback', 'UGControl@feedback');
$router->post('/ug/feedback/create', 'UGControl@createFeedback');
$router->post('/ug/feedback/edit', 'UGControl@editFeedback');
$router->post('/ug/feedback/delete', 'UGControl@deleteFeedback');
$router->get('/ug/feedback/get', 'UGControl@getFeedbackById');

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

// Admin POST routes for form submissions
$router->post('/admin/manage-users/create', 'AdminControl@createUser');
$router->post('/admin/manage-users/update', 'AdminControl@updateUser');
$router->post('/admin/manage-users/delete', 'AdminControl@deleteUser');

$router->get('/counselor', 'COControl@index');  
$router->get('/counselor/dashboard', 'COControl@dashboard');
$router->get('/counselor/appointmentmgt', 'COControl@appointmentmgt');
$router->get('/counselor/calender', 'COControl@calender');
$router->get('/counselor/sessionHistory', 'COControl@sessionHistory');
$router->get('/counselor/counselor_profile', 'COControl@counselorProfile');
$router->get('/counselor/forum', 'UGControl@forum');
$router->get('/counselor/resources', 'UGControl@resources');

// Counselor calendar API routes
$router->post('/counselor/createEvent', 'COControl@createEvent');
$router->post('/counselor/updateEvent', 'COControl@updateEvent');
$router->post('/counselor/deleteEvent', 'COControl@deleteEvent');
$router->get('/counselor/getEventsByDate', 'COControl@getEventsByDate');
$router->get('/counselor/getEventsByMonth', 'COControl@getEventsByMonth');
$router->get('/counselor/getEventById', 'COControl@getEventById');

// Minimal Appointment APIs (create + counselors list)
$router->get('/api/counselors', 'AppointmentApiControl@listCounselors');
$router->get('/api/test', 'AppointmentApiControl@test');
$router->post('/api/appointments/create', 'AppointmentApiControl@create');
$router->put('/api/appointments/update', 'AppointmentApiControl@update');
$router->delete('/api/appointments/delete', 'AppointmentApiControl@delete');

// Habits API
$router->get('/api/habits', 'HabitApiControl@list');
$router->post('/api/habits/create', 'HabitApiControl@create');
$router->put('/api/habits/update', 'HabitApiControl@update');
$router->delete('/api/habits/delete', 'HabitApiControl@delete');
$router->post('/api/habits/complete', 'HabitApiControl@complete');
$router->post('/api/habits/uncomplete', 'HabitApiControl@uncomplete');
$router->get('/api/habits/stats', 'HabitApiControl@stats');
$router->get('/api/habits/test', 'HabitApiControl@test');

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

// Moderator resource management routes
$router->post('/Moderator/resource/create', 'ModeratorControl@createResource');
$router->post('/Moderator/resource/delete', 'ModeratorControl@deleteResource');
$router->get('/Moderator/resource/edit', 'ModeratorControl@editResource');
$router->post('/Moderator/resource/update', 'ModeratorControl@updateResource');

$router->get('/UniversityRepresentative/dashboard', 'UniversityRepresentativeControl@index');
// ========================================
// UNIVERSITY REPRESENTATIVE ROUTES
// ========================================

// Dashboard
$router->get('/university-rep', 'UniversityRepresentativeControl@dashboard');
$router->get('/university-rep/dashboard', 'UniversityRepresentativeControl@dashboard');

// Events Management
$router->get('/university-rep/events', 'UniversityRepresentativeControl@events');
$router->get('/university-rep/events/create', 'UniversityRepresentativeControl@createEvent');
$router->post('/university-rep/events/store', 'UniversityRepresentativeControl@storeEvent');
$router->get('/university-rep/events/view/{id}', 'UniversityRepresentativeControl@viewEvent');
$router->get('/university-rep/events/edit/{id}', 'UniversityRepresentativeControl@editEvent');
$router->post('/university-rep/events/update', 'UniversityRepresentativeControl@updateEvent');
$router->post('/university-rep/events/delete', 'UniversityRepresentativeControl@deleteEvent');

// Announcements Management
$router->get('/university-rep/announcements', 'UniversityRepresentativeControl@announcements');
$router->get('/university-rep/announcements/create', 'UniversityRepresentativeControl@createAnnouncement');
$router->post('/university-rep/announcements/store', 'UniversityRepresentativeControl@storeAnnouncement');
$router->post('/university-rep/announcements/delete', 'UniversityRepresentativeControl@deleteAnnouncement');

// Resources Management
$router->get('/university-rep/resources', 'UniversityRepresentativeControl@resources');
$router->get('/university-rep/resources/create', 'UniversityRepresentativeControl@createResource');
$router->post('/university-rep/resources/store', 'UniversityRepresentativeControl@storeResource');
$router->post('/university-rep/resources/delete', 'UniversityRepresentativeControl@deleteResource');

// University Profile
$router->get('/university-rep/university-profile', 'UniversityRepresentativeControl@universityProfile');
$router->post('/university-rep/university-profile/update', 'UniversityRepresentativeControl@updateUniversityProfile');

// Analytics
$router->get('/university-rep/analytics', 'UniversityRepresentativeControl@analytics');

// Profile Management
$router->get('/university-rep/profile', 'UniversityRepresentativeControl@profile');
$router->post('/university-rep/profile/update', 'UniversityRepresentativeControl@updateProfile');



$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);