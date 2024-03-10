<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Repositories\ClientRepository;

class ClientController extends Controller

{
    public function __construct(Client $client){
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ClientRepository = New ClientRepository($this->client);

        if($request->has('filter')){
            $ClientRepository->filter($request->filter);
        }
        if($request->has('params')){
            $ClientRepository->selectAttributes($request->params);
        }

        $client = $ClientRepository->getResult();

        if($client === null){
            return response()->json(['erro' => 'Nenhum registro encontrado'],404);
        }
        return response()->json($client,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->client->rules(), $this->client->feedback());
        
        $client = $this->client->create([
            'name' => $request->name,
          
        ]);

        return response()->json($client,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $client = $this->client->find($id);
        if($client === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }
        return response()->json($client,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$brand->update($request->all());

        $client = $this->client->find($id);
        if($client === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            if($request->method() == 'PATCH'){
                $dynamicRules = array();
                foreach($client->rules() as $input => $rule){
                    if(array_key_exists($input, $request->all())){
                        $dynamicRules[$input] = $rule;
                    }
                }
                $request->validate($dynamicRules, $client->feedback());
            }else{
                $request->validate($client->rules(), $client->feedback());
            }

            $client->fill($request->all());
            $client->save();
            
            return response()->json($client,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $client = $this->client->find($id);
        if($client === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            $client->delete();
            return response()->json(['msg' => 'Registro removido com sucesso!'],200);
        }        
    }
}
