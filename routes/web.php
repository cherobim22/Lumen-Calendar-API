<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond tocreate
| and give it the Closure to call when that URI is requested.
|
*/
//autenticação
$router->get('/auth', 'LoginController@Auth');
$router->get('/callback', 'LoginController@Callback');

//Database
$router->get('/clients', 'ClientController@buscarTodos');
$router->get('/clients/{id}', 'ClientController@buscarClientes');
$router->delete('/clients/{id}', 'ClientController@deletarClientes');
$router->put('/clients/{id}', 'ClientController@updateClient');

//calendario
$router->get('/calendars/{id}', 'GoogleCalendarController@listCalendars');
$router->post('/createCalendar/{id}', 'GoogleCalendarController@createCalendar');
$router->put('/updateCalendar/{id}', 'GoogleCalendarController@updateCalendar');
$router->delete('/deletCalendar/{id}', 'GoogleCalendarController@deleteCalendar');

//eventos
$router->get('/events/{id}', 'GoogleCalendarController@listEvents');
$router->post('/createEvents/{id}', 'GoogleCalendarController@createEvents');
$router->put('/updateEvents/{id}', 'GoogleCalendarController@updateEvents');
$router->delete('/deletEvents/{id}', 'GoogleCalendarController@deleteEvents');
