<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use App\Helpers\GoogleClientHelper;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;


class GoogleClientController extends Controller {
    //__contruct
    public function __construct(GoogleClientHelper $clientHelper, GoogleClient $client){
        $clientHelper = new GoogleClientHelper;
        $this->clientHelper = $clientHelper;
    }

    /**
     * Funcao que gera a url de acesso ao token
     *
     */
    public function Auth(){
        $url_acesso = $this->clientHelper->getAuthUrl();
        return $url_acesso;
    }

    /**
     * Funcao que retorna e salva o token no banco
     */
    public function Callback(Request $request){
        $this->clientHelper->setCode($request->get('code'));
        $token = $this->clientHelper->getToken();
        print_r(json_encode($token));
        //model
        $client = new GoogleClient;
        $client->blog_id = '333';
        $client->access_token =  $token['access_token'];
        $client->expires_in = $token['expires_in'];
        $client->refresh_token = $token['refresh_token'];
        $client->created = $token['created'];
        $client->save();
    }

     /**
     * Funcao para buscar evento de um usuario
     * @param int $id do usario contido no banco
     * @return array Um array de eventos
     */
    public function getEvents(int $id){
        //select from db
        $this->client = new GoogleClient;
        $user = $this->client::select('access_token','refresh_token')->where('id', $id)->first();
        $this->clientHelper->setToken($user);
        $events = $this->clientHelper->getEvents();
        return $events;
    }

    /**
     * Funcao para criar um evento
     * @param int $id do usario contido no banco
     * @param Request Sumario, Descrição, Hora Inicio, Hora Fim, Participantes
     * @return Obj objeto do evento criado
     */
    public function createEvents(int $id, Request $request){
         //select from db
         $client = new GoogleClient;
         $user = $client::select('access_token','refresh_token')->where('id',$id)->first();

         $gd_client = new GoogleCLientHelper;
         $gd_client->setToken($user);
         $event = $gd_client->createEvent($request);
         return json_encode($event);
    }

    /**
     * Funcao para atualizar um evento
     * @param int $id do usario contido no banco
     * @param Request Sumario, Descrição, Hora Inicio, Hora Fim
     * @return Obj objeto do evento atualizado
     */
    public function updateEvents(int $id, Request $request){
          //select from db
          $client = new GoogleClient;
          $user = $client::select('access_token','refresh_token')->where('id',$id)->first();
          //helper
          $gd_client = new GoogleCLientHelper;
          $gd_client->setToken($user);
          $event = $gd_client->updateEvents($request);
          return json_encode($event);
    }

     /**
     * Funcao para deletar eventos de um usuario
     * @param int $id do usario contido no banco
     * @param Request calendar_id
     * @return array Um array de eventos
     */
    public function deleteEvents(int $id, Request $request){
        $client = new GoogleClient;
          $user = $client::select('access_token','refresh_token')->where('id',$id)->first();
          //helper
          $gd_client = new GoogleCLientHelper;
          $gd_client->setToken($user);
          $event = $gd_client->deleteEvents($request);
    }

    //CALENDAR
    /**
     * Funcao que lista todos os calendarios
     */
    public function getCalendars(int $id){
        //select from db
        $client = new GoogleClient;
        $user = $client::select('access_token','refresh_token')->where('id', $id)->first();
        //helper
        $gd_client = new GoogleCLientHelper;
        $gd_client->setToken($user);
        $calendars = $gd_client->listCalendars();
        return json_encode($calendars);

        //return $calendars; //ERRO 500 must be of the type string or null
    }

    /**
     * Funcao que cria um novo calendario
     */
    public function newCalendar(int $id, Request $request){
        //select from db
        $client = new GoogleClient;
        $user = $client::select('access_token','refresh_token')->where('id',$id)->first();
        //helper
        $gd_client = new GoogleCLientHelper;
        $gd_client->setToken($user);
        $newCalendar = $gd_client->createCalendar($request);

        return json_encode($newCalendar);
    }

    /**
     * Funcao que deleta um calendario
     */
    public function deletCalendar(int $id, Request $request){
        //select from db
        $client = new GoogleClient;
        $user = $client::select('access_token','refresh_token')->where('id',$id)->first();
        //helper
        $gd_client = new GoogleCLientHelper;
        $gd_client->setToken($user);
        $delet = $gd_client->deleteCalendar($request);
        return $delet;
    }

    /**
     * Funcao que atualiza um calendario
     */
    public function updateCalendar(int $id, Request $request){
         //select from db
         $client = new GoogleClient;
         $user = $client::select('access_token','refresh_token')->where('id',$id)->first();
         //helper
         $gd_client = new GoogleCLientHelper;
         $gd_client->setToken($user);
         $update = $gd_client->updateCalendar($request);
         return json_encode($update);

    }

    public function buscarClientes(){
        $googleClient = new GoogleClient();
        return $googleClient->all();
    }

    private $client;
    private $clientHelper;

}
