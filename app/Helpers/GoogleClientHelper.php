<?php

namespace App\Helpers;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
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
     *
     * @param string $calendar_id Se passar como null vai ser da agenda primaria
     * @return array Um array de eventos
     */
    public function getEvents(){
        if(!$this->is_authenticated){
            throw new Exception("Você precisa autenticar primeiro", 1);
        }
        if(!$this->calendar){
            $this->setCalendar($this->calendar_id);
        }
        $optParams = array(
            'orderBy' => 'startTime' ,
            'singleEvents' => true,
            'timeMin' => date('c'),//0000-01-01T20:38:58+02:00
        );
        $results = $this->calendar->events->listEvents($this->calendar_id, $optParams);
        return $results->getItems();
    }

 /**
     * Funcao para criar um novo CALENDARIO
     * Sumario
     * @return Msg com o nome do CALENDARIO
     */
    public function createCalendar(Request $request){
        if(!$this->service){
            $this->setCalendarService($this->client);
        }
        $calendarEntry =  new Google_Service_Calendar_Calendar();
        $calendarEntry->setSummary($request->get('summary'));
        $createdCalendar = $this->service->calendars->insert($calendarEntry);
        return $createdCalendar->getSummary();
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
    private $code;
    private $token;
    private $calendar_id = "primary";
    //private $redirect_uri = "https://cherobim.innovaweb.com.br/allan/callback.php";
    private $redirect_uri = "http://localhost:8000/callback";
}
