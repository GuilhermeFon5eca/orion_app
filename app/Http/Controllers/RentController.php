<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use App\Repositories\RentRepository;

class RentController extends Controller
{
    public function __construct(Rent $rent){
        $this->rent = $rent;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rentRepository = New rentRepository($this->rent);

        if($request->has('filter')){
            $rentRepository->filter($request->filter);
        }
        if($request->has('params')){
            $rentRepository->selectAttributes($request->params);
        }

        $rent = $rentRepository->getResult();

        if($rent === null){
            return response()->json(['erro' => 'Nenhum registro encontrado'],404);
        }
        return response()->json($rent,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rent->rules(), $this->rent->feedback());
        
        $rent = $this->rent->create([
            'client_id'=> $request->client_id,
            'car_id' => $request->car_id,
            'rent_id' => $request->rent_id,
            'data_start_rent' => $request->data_start_rent,
            'data_foreseen_end_rent' => $request->data_foreseen_end_rent,
            'data_end_rent' => $request->data_end_rent,
            'daily_rate' => $request->daily_rate,
            'km_initial' => $request->km_initial,
            'km_final' => $request->km_final,
        ]);

        return response()->json($rent,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $rent = $this->rent->find($id);
        if($rent === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }
        return response()->json($rent,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$brand->update($request->all());

        $rent = $this->rent->find($id);
        if($rent === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            if($request->method() == 'PATCH'){
                $dynamicRules = array();
                foreach($rent->rules() as $input => $rule){
                    if(array_key_exists($input, $request->all())){
                        $dynamicRules[$input] = $rule;
                    }
                }
                $request->validate($dynamicRules, $rent->feedback());
            }else{
                $request->validate($rent->rules(), $rent->feedback());
            }

            $rent->fill($request->all());
            $rent->save();
            
            return response()->json($rent,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $rent = $this->rent->find($id);
        if($rent === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            $rent->delete();
            return response()->json(['msg' => 'Registro removido com sucesso!'],200);
        }        
    }
}
