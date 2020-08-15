<?php

namespace App\Http\Controllers;

use App\Models\GoogleClient;
use Illuminate\Http\Request;

class GoogleClientController extends Controller
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
        $buscar_clientes = $this->client->find($id);
        if($client != null){
            return response()->json($buscar_clientes, 200);
        }else{
            return response()->json("cliente não encontrado", 404);
        }
    }

     /**
     * Funcao para deletar um cliente
     * @param id do cliente
     */
    public function deletarClientes(int $id){
        $client_delete = $this->client->find($id);
        if($client_delete != null){
            $client_delete->delete($id);
            return response()->json("ok", 200);
        }else{
            return response()->json("cliente não encontrado", 404);
        }
    }

     /**
     * Funcao para Atualizar um client
     * @param id do cliente
     */
    public function updateClient(int $id, Request $request){
        $client_update = $this->client->find($id);
        if($client_update != null){
            $client_update->update($request->all());
            return response()->json($client_update, 200);
        }else{
            return response()->json("cliente não encontrado", 404);
        }
    }

    private $client;
}
