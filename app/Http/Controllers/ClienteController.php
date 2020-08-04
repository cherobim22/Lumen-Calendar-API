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
        print_r(json_encode($token));
    }

    public function buscarClientes(){
        $googleClient = new GoogleClient();
        return $googleClient->all();
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
