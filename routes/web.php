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
