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
$router->get('/auth', 'LoginController@Auth');
$router->get('/callback', 'LoginController@Callback');

//calendario
$router->get('/calendars/{id}', 'GoogleClientController@listCalendars');
$router->post('/createCalendar/{id}', 'GoogleClientController@createCalendar');
$router->put('/updateCalendar/{id}', 'GoogleClientController@updateCalendar');
$router->delete('/deletCalendar/{id}', 'GoogleClientController@deleteCalendar');

//eventos
$router->get('/events/{id}', 'GoogleClientController@listEvents');
$router->post('/createEvents/{id}', 'GoogleClientController@createEvents');
$router->put('/updateEvents/{id}', 'GoogleClientController@updateEvents');
$router->delete('/deletEvents/{id}', 'GoogleClientController@deleteEvents');
