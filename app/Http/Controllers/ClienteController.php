<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use App\Helpers\GoogleClientHelper;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;


class ClienteController extends Controller {
    //__contruct

    public function Auth(){
        $gd_client = new GoogleClientHelper;
        $url_acesso = $gd_client->getAuthUrl();
        return $url_acesso;
    }

    public function Callback(Request $request){
        //helper
        $gd_client = new GoogleCLientHelper;
        $gd_client->setCode($request->get('code'));
        $token = $gd_client->getToken();

        print_r(json_encode($token));

        //modelo
        $client = new GoogleClient;
        $client->blog_id = '333';
        $client->access_token =  $token['access_token'];
        $client->expires_in = $token['expires_in'];
        $client->refresh_token = $token['refresh_token'];
        $client->created = $token['created'];
        $client->save();
    }

    public function getEvents(int $id){
        //select from db
        $this->client = new GoogleClient;
        $user = $this->client::select('access_token','refresh_token')->where('id', $id)->first();

        //helper
        $gd_client = new GoogleCLientHelper;
        $gd_client->setToken($user);
        $events = $gd_client->getEvents();

        return $events;
    }

    public function newCalendar(int $id, Request $request){
        //select from db
        $client = new GoogleClient;
        $user = $client::select('access_token','refresh_token')->where('id',$id)->first();
        //helper
        $gd_client = new GoogleCLientHelper;
        $gd_client->setToken($user);
        $newCalendar = $gd_client->createCalendar($request);

    }

    public function buscarClientes(){
        $googleClient = new GoogleClient();
        return $googleClient->all();
    }

    private $client = null;

}
