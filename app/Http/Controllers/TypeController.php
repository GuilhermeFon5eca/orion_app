<?php

namespace App\Http\Controllers;

use App\Repositories\TypeRepository;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct(Type $type){
        $this->type = $type;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $typeRepository = New TypeRepository($this->type);

        if($request->has('params_brand')){
            $params_brand = 'brand:id,'.$request->params_brand;
            $typeRepository->selectAttributesRelatedRegisters($params_brand);
        }else{
            $typeRepository->selectAttributesRelatedRegisters('brand');
        }



        if($request->has('filter')){
            $typeRepository->filter($request->filter);
        }
        if($request->has('params')){
            $typeRepository->selectAttributes($request->params);
        }

        $types = $typeRepository->getResult();

        if($types === null){
            return response()->json(['erro' => 'Nenhum registro encontrado'],404);
        }
        return response()->json($types,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate($this->type->rules(), $this->type->feedback());
        
        //Image store
        $image = $request->file('image');
        $image_urn = $image->store('files/types','public');

        $type = $this->type->create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'image' => $image_urn,
            'doors_number' => $request->doors_number,
            'seats' => $request->seats,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json($type,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $type = $this->type->with('brand')->find($id);
        if($type === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }
        return response()->json($type,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $type = $this->type->find($id);
        if($type === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            if($request->method() == 'PATCH'){
                $dynamicRules = array();
                foreach($type->rules() as $input => $rule){
                    if(array_key_exists($input, $request->all())){
                        $dynamicRules[$input] = $rule;
                    }
                }
                $request->validate($dynamicRules, $type->feedback());
            }else{
                $request->validate($type->rules(), $type->feedback());
            }

            if($request->file('image')){
                Storage::disk('public')->delete($type->image);
            }
            
            //Image store
            $image = $request->file('image');
            $image_urn = $image->store('files/types','public');

            $type->fill($request->all());
            $type->image = $image_urn;
            $type->save();
            // $type->update([
            //     'brand_id' => $request->brand_id,
            //     'name' => $request->name,
            //     'image' => $image_urn,
            //     'doors_number' => $request->doors_number,
            //     'seats' => $request->seats,
            //     'air_bag' => $request->air_bag,
            //     'abs' => $request->abs,
            // ]);
            return response()->json($type,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $type = $this->type->find($id);
        if($type === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            Storage::disk('public')->delete($type->image);
            $type->delete();
            return response()->json(['msg' => 'Registro removido com sucesso!'],200);
        }   
    }
}
