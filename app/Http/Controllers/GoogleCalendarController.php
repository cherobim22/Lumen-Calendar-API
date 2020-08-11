<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use App\Helpers\GoogleClientHelper;
use Illuminate\Http\Request;

class GoogleCalendarController extends Controller {
    //__contruct
    public function __construct(GoogleClientHelper $clientHelper){
        $clientHelper = new GoogleClientHelper;
        $this->clientHelper = $clientHelper;
    }

    /**
     * Funcao que define o usuario de acesso
     * @param int $id do usario contido no banco
     */
    public function setAccess(int $id){
        $this->client = new GoogleClient;
        $google_client = $this->client::select('access_token','refresh_token')->where('id', $id)->first();
        return $google_client;
    }

     /**
     * Funcao para buscar evento de um usuario
     * @param int $id do usario contido no banco
     * @return array Um array de eventos
     */
    public function listEvents(int $id, Request $request){
        $this->user = $this->setAccess($id);
        $this->clientHelper->setToken($this->user);
        if($request->has('calendar_id')){
            $this->clientHelper->setCalendarId($request->input('calendar_id'));
        }
        $events = $this->clientHelper->getEvents();
        return response()->json($events, 200);
    }

    /**
     * Funcao para criar um evento
     * @param int $id do usario contido no banco
     * @param Request calendar_id, event_id, summary, description, start_datetime, end_datetime, attendee_1, attendee_2
     * @return Obj objeto do evento criado
     */
    public function createEvents(int $id, Request $request){
        $this->user = $this->setAccess($id);
        if($request->has('calendar_id')){
            $this->clientHelper->setCalendarId($request->input('calendar_id'));
        }
        $this->clientHelper->setToken($this->user);
        $event = $this->clientHelper->createEvent($request);
        return json_encode($event);
    }

    /**
     * Funcao para atualizar um evento
     * @param int $id do usario contido no banco
     * @param Request calendar_id, event_id, summary, description, start_datetime, end_datetime, attendee_1, attendee_2
     * @return Obj objeto do evento atualizado
     */
    public function updateEvents(int $id, Request $request){
          $this->user = $this->setAccess($id);
          if($request->has('calendar_id')){
            $this->clientHelper->setCalendarId($request->input('calendar_id'));
        }
          $this->clientHelper->setToken($this->user);
          $event = $this->clientHelper->updateEvents($request);
          return json_encode($event);
    }

     /**
     * Funcao para deletar eventos de um usuario
     * @param int $id do usario contido no banco
     * @param Request calendar_id, event_id
     */
    public function deleteEvents(int $id, Request $request){
       $this->user = $this->setAccess($id);
       if($request->has('calendar_id')){
         $this->clientHelper->setCalendarId($request->input('calendar_id'));
     }
     $this->clientHelper->setToken($this->user);
          $event = $this->clientHelper->deleteEvents($request);
    }

    //CALENDAR
    /**
     * Funcao que lista todos os calendarios
     * @param int $id do usario contido no banco
     * @return array de calendarios
     */
    public function listCalendars(int $id){
        $this->user = $this->setAccess($id);
        $this->clientHelper->setToken($this->user);
        $calendars = $this->clientHelper->listCalendars();
        return json_encode($calendars);
    }

    /**
     * Funcao que cria um novo calendario
     * @return Obj objeto do calendario criado
     */
    public function createCalendar(int $id, Request $request){
        $this->user = $this->setAccess($id);
        $this->clientHelper->setToken($this->user);
        $newCalendar = $this->clientHelper->createCalendar($request);
        return json_encode($newCalendar);
    }

    /**
     * Funcao que deleta um calendario
     * @param int $id do usario contido no banco
     * @param Request calendar_id
     */
    public function deleteCalendar(int $id, Request $request){
        $this->user = $this->setAccess($id);
        $this->clientHelper->setToken($this->user);
        $delete = $this->clientHelper->deleteCalendar($request);
        return $delete;
    }

    /**
     * Funcao que atualiza um calendario
     * @param Request calendar_id
     * @return Obj objeto do calendario atualizado
     */
    public function updateCalendar(int $id, Request $request){
        $this->user = $this->setAccess($id);
        $this->clientHelper->setToken($this->user);
        $update = $this->clientHelper->updateCalendar($request);
         return json_encode($update);

    }

    private $client;
    private $user;
    private $clientHelper;
}
