<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use App\Helpers\GoogleClientHelper;
use Google_Client;
use Google_Service_Calendar;

class ClienteController extends Controller {

    public function Auth(){
        $gd_client = new GoogleClientHelper;
        $url_acesso = $gd_client->getAuthUrl();
        return $url_acesso;
    }

    public function Callback(){
        $gd_client = new GoogleCLientHelper;
        $gd_client->setCode($_GET['code']);
        $token = $gd_client->getToken();

        $access_token = $token['access_token'];
        $expires_in = $token['expires_in'];
        $refresh_token = $token['refresh_token'];
        $created = $token['created'];

        print_r($token);
        

    }

    public function buscarClientes(){
        $googleClient = new GoogleClient();
        return $googleClient->all();
    }

}
