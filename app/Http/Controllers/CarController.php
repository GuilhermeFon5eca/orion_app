<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Repositories\CarRepository;

class CarController extends Controller
{

    public function __construct(Car $car){
        $this->car = $car;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $CarRepository = New CarRepository($this->car);

        if($request->has('params_brand')){
            $params_brand = 'type:id,'.$request->params_brand;
            $CarRepository->selectAttributesRelatedRegisters($params_brand);
        }else{
            $CarRepository->selectAttributesRelatedRegisters('type');
        }



        if($request->has('filter')){
            $CarRepository->filter($request->filter);
        }
        if($request->has('params')){
            $CarRepository->selectAttributes($request->params);
        }

        $car = $CarRepository->getResult();

        if($car === null){
            return response()->json(['erro' => 'Nenhum registro encontrado'],404);
        }
        return response()->json($car,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->car->rules(), $this->car->feedback());
        
        $car = $this->car->create([
            'type_id' => $request->type_id,
            'plate' => $request->plate,
            'available' => $request->available,
            'km' => $request->km,
        ]);

        return response()->json($car,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $car = $this->car->with('type')->find($id);
        if($car === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }
        return response()->json($car,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$brand->update($request->all());

        $car = $this->car->find($id);
        if($car === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            if($request->method() == 'PATCH'){
                $dynamicRules = array();
                foreach($car->rules() as $input => $rule){
                    if(array_key_exists($input, $request->all())){
                        $dynamicRules[$input] = $rule;
                    }
                }
                $request->validate($dynamicRules, $car->feedback());
            }else{
                $request->validate($car->rules(), $car->feedback());
            }

            $car->fill($request->all());
            $car->save();
            
            return response()->json($car,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $car = $this->car->find($id);
        if($car === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            $car->delete();
            return response()->json(['msg' => 'Registro removido com sucesso!'],200);
        }        
    }
}
