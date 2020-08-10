<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use App\Helpers\GoogleClientHelper;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //__contruct
    public function __construct(GoogleClient $googleClient)
    {
        $this->client = $googleClient;
    }

     /**
     * Funcao para buscar todos os clientes do banco
     * @return Array de objetos
     */
    public function buscarTodos(){
        return $this->client->all();
    }

     /**
     * Funcao para buscar um cliente especifico
     * @return Obj
     */
    public function buscarClientes(int $id){
        return $this->client->find($id);
    }

     /**
     * Funcao para deletar um cliente
     * @param id do cliente
     */
    public function deletarClientes(int $id){
        $client_delete = $this->client->find($id);
        return $client_delete->delete($id);
    }

     /**
     * Funcao para Atualizar um client
     * @param id do cliente
     */
    public function updateClient(int $id, Request $request){
       return $this->client->where('id', $id)->update($request->all());
    }

    private $client;
}
