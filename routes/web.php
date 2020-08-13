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

$router->group(['prefix' => 'google'], function() use ($router){

    $router->group(['prefix' => 'client'], function() use ($router){
        $router->get('/', 'GoogleClientController@buscarTodos');
        $router->get('/{id}', 'GoogleClientController@buscarClientes');
        $router->delete('/{id}', 'GoogleClientController@deletarClientes');
        $router->put('/{id}', 'GoogleClientController@updateClient');
    });

    $router->group(['prefix' => 'login'], function() use ($router){
        $router->get('/auth', 'GoogleLoginController@auth');
        $router->get('/callback', 'GoogleLoginController@callback');
    });

    $router->group(['prefix' => 'calendar'], function() use ($router){
        $router->get('/read/{id}', 'GoogleCalendarController@listCalendars');
        $router->post('/create/{id}', 'GoogleCalendarController@createCalendar');
        $router->put('/update/{id}', 'GoogleCalendarController@updateCalendar');
        $router->delete('/delete/{id}', 'GoogleCalendarController@deleteCalendar');
    });

    $router->group(['prefix' => 'events'], function() use ($router){
        $router->get('/read/{id}', 'GoogleCalendarController@listEvents');
        $router->post('/create/{id}', 'GoogleCalendarController@createEvents');
        $router->put('/update/{id}', 'GoogleCalendarController@updateEvents');
        $router->delete('/delete/{id}', 'GoogleCalendarController@deleteEvents');
    });
});
