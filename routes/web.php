<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

<<<<<<< HEAD
//autenticação
$router->get('/auth', 'GoogleClientController@Auth');
$router->get('/callback', 'GoogleClientController@Callback');

//calendario
$router->post('/createCalendar/{id}', 'GoogleClientController@newCalendar');
$router->get('/calendars/{id}', 'GoogleClientController@getCalendars');
$router->post('/deletCalendar/{id}', 'GoogleClientController@deletCalendar');
$router->post('/updateCalendar/{id}', 'GoogleClientController@updateCalendar');

//eventos
$router->get('/events/{id}', 'GoogleClientController@getEvents');
$router->post('/createEvents/{id}', 'GoogleClientController@createEvents');
$router->post('/updateEvents/{id}', 'GoogleClientController@updateEvents');
$router->post('/deletEvents/{id}', 'GoogleClientController@deleteEvents');
=======
$router->get('/auth', 'ClienteController@Auth');
$router->get('/callback', 'ClienteController@Callback');
$router->get('/list/{id}', 'ClienteController@getEvents');
$router->post('/create/{id}', 'ClienteController@newCalendar');

>>>>>>> b3e0c0a88f0004fee7eaa614e2357ee9900d010e
