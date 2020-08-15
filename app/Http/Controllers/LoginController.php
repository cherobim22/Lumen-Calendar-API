<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use App\Helpers\GoogleClientHelper;
use Illuminate\Http\Request;


class GoogleLoginController extends Controller {
    //__contruct
    public function __construct(GoogleClientHelper $clientHelper){
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
    public function Callback (Request $request){
        $this->clientHelper->setCode($request->get('code'));
        $token = $this->clientHelper->getToken();

        $state = $request->get('state');
        $state_64 = base64_decode($state);
        $stateDecode = json_decode($state_64, true);
        $user_id = $stateDecode['user_id'];
        //decode
        //
        print_r(json_encode($user_id));
        print_r(json_encode($token));
        //model
        $this->client = new GoogleClient;
        $this->client->user_id = $user_id;
        $this->client->access_token =  $token['access_token'];
        $this->client->expires_in = $token['expires_in'];
        $this->client->refresh_token = $token['refresh_token'];
        $this->client->created = $token['created'];
        $this->client->save();
    }

    private $client;
    private $clientHelper;
}
