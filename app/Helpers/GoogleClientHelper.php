<?php

namespace App\Helpers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Http\Request;

/**
 * Classe para lidar com as automacoes
 */
class GoogleClientHelper {

    public function __construct(){
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('keys/credentials.json'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        return $this;
    }

    /**
     * Funcao para buscar a url em que o cliente vai autenticar
     *
     * @return string Url em que o cliente tem que acessar
     */
    public function getAuthUrl(){
        $this->client->setRedirectUri($this->redirect_uri);
        $this->client->setApprovalPrompt('force');
        $this->client->setIncludeGrantedScopes(true);

        return $this->client->createAuthUrl();
    }
    /**
     * Funcao para setar o code
     */
    public function setCode($code){
        $this->code = $code;
    }
    /**
     * Seta os atributos do token, expires, token, refresh_token,scope
     */
    public function setToken($arr_token){
        $this->token = $arr_token;
        $this->client->setAccessToken($this->token);
        if($this->client->isAccessTokenExpired($this->token)){
            $this->client->refreshToken($this->token['refresh_token']);
            $this->token = $this->client->getAccessToken();
            $this->client->setAccessToken($this->token['access_token']);
            //atualizaria no banco
        }
        $this->is_authenticated = true;
    }
    /**
     * Funcao para buscar o token com o code
     * @return Array Array com token, expires, escopo, refresh token
     */
    public function getToken(){
        $this->client->setRedirectUri($this->redirect_uri);
        $this->client->setIncludeGrantedScopes(true);
        $this->client->authenticate($this->code);
        return $this->client->getAccessToken();
    }

    /**
     * Funcao para buscar os eventos
     * @param string $calendar_id Se passar como null vai ser da agenda primaria
     * @return array Um array de eventos
     */
    public function getEvents(){
        if(!$this->is_authenticated){
            throw new Exception("Você precisa autenticar primeiro", 1);
        }
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $optParams = array(
            'orderBy' => 'startTime' ,
            'singleEvents' => true,
            'timeMin' => date('c'),//0000-01-01T20:38:58+02:00
        );
        $results = $this->service->events->listEvents($this->calendar_id, $optParams);
        return $results->getItems();
    }

    /**
     * Funcao para criar um evento
     * @param Request calendarID, event_id, summary, description, start-datetime, end_datetime, attendee_1, attendee_2
     * @return Obj objeto do evento criado
     */
    public function createEvent(Request $request){
        if(!$this->is_authenticated){
            throw new Exception("Você precisa autenticar primeiro", 1);
        }
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $event = [
            'start' => array('dateTime' => $request->get('start_datetime'), 'timeZone' => 'America/Sao_Paulo'),
            'end' => array('dateTime' => $request->get('end_datetime'), 'timeZone' => 'America/Sao_Paulo'),
            'attendees' => array(
                array('email' => $request(['attendee_1'])),
                array('email' => $request(['attendee_2'])),
            )
        ];
        if($request->get('description') !== NULL){
            $event['description'] = $request->get('description');
        }
        if($request->get('summary') !== NULL){
            $event['summary'] = $request->get('summary');
        }
        $optParams = new Google_Service_Calendar_Event($event);
        $creat_event = $this->service->events->insert($this->calendar_id, $optParams);
        return $creat_event;
    }

    /**
     * Funcao para atualizar um evento
     * @param Request calendarID, event_id, summary, description, start_datetime, end_datetime
     * @return Obj objeto do evento atualizado
     */
    public function updateEvents(Request $request){
        $id_event = $request->input('event_id');

        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $event = $this->service->events->get($this->calendar_id, $id_event);
        if($request->has('summary')){
          $event->setSummary($request->input('summary'));
        }
        if($request->get('description') !== NULL){
             $event->setDescription($request->get('description'));
        }
        //inicio e fim
        $serviceDateTime = new Google_Service_Calendar_EventDateTime();
        if($request->has('start_datetime')){
            $start = $serviceDateTime;
            $start->setDateTime($request->get('start_datetime'));
            $start->setTimeZone('America/Sao_Paulo');
            $event->setStart($start);
        }
        if($request->has('end_datetime')){
            $end = $serviceDateTime;
            $end->setDateTime($request->input('end_datetime'));
            $end->setTimeZone('America/Sao_Paulo');
            $event->setEnd($end);
        }

        $updateEvent = $this->service->events->update($this->calendar_id, $id_event, $event );
        return $updateEvent;
    }

      /**
     * Funcao para deletar um evento
     * @param Request  calendar_id, event_id
     * @return Msg deletado
     */
    public function deleteEvents(Request $request){
        $id_event = $request->input('event_id');
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        try{
             $deletEvent = $this->service->events->delete($this->calendar_id, $id_event);
             return "deletado";
        }catch (Exception $e) {
            echo 'Evento não encontrado: ',  $e->getMessage(), "\n";
        }
    }

    /**
    * Funcao para listar CALENDARIOS
    * @return array de calendarios
    */
    public function listCalendars(){
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $optParams = 'maxResults';
        $results = $this->service->calendarList->listCalendarList();
        return $results;
     }

    /**
     * Funcao para criar um novo CALENDARIO
     * @param Request summary
     * @return Msg nome do CALENDARIO
     */
    public function createCalendar(Request $request){
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $calendarEntry =  new Google_Service_Calendar_Calendar();
        $calendarEntry->setSummary($request->get('summary'));
        $createdCalendar = $this->service->calendars->insert($calendarEntry);
        return $createdCalendar;
     }

      /**
     * Funcao para deletar um CALENDARIO
     * @param Request calendar_id
     * @return Msg deletado
     */
    public function deleteCalendar(Request $request){
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        try{
            $id = $request->get('calendarId');
            $deleteCalendar = $this->service->calendars->delete($id);
            return "deletado";
       }catch (Exception $e) {
           echo 'Calendario não encontrado: ',  $e->getMessage(), "\n";
       }
    }

     /**
     * Funcao para atualizar um CALENDARIO
     * @param Request calendar_id, summary
     * @return Msg deletado
     */
    public function updateCalendar(Request $request){
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $id = $request->get('calendarId');
        $calendar = $this->service->calendars->get($id);
        $calendar->setSummary($request->get('summary'));
        $updatedCalendar = $this->service->calendars->update($id, $calendar);
        return $updatedCalendar;
    }

     /**
     *
     * Funcao para criar uma instancia do calendar
     */
    private function setCalendar($calendar_id){
        $this->calendar = new Google_Service_Calendar($this->client);
    }

    /**
     * Funcao para setar o id do calendar
     */
    public function setCalendarId($calendar_id){
        $this->calendar_id = $calendar_id;
    }

    /**
     * Funcao para criar um novo serviço do calendar
     */
    public function setCalendarService($client){
        $this->service = new Google_Service_Calendar($this->client);
    }

    private $calendar = null;
    private $service = null;
    private $is_authenticated = false;
    private $client;
    private $code;
    private $token;
    private $calendar_id = 'primary';
    private $redirect_uri = "https://cherobim.innovaweb.com.br/callback";
   // private $redirect_uri = "http://localhost:8000/callback";
}
