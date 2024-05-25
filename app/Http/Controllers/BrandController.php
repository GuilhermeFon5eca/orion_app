<?php

namespace App\Http\Controllers;

use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function __construct(Brand $brand){
        $this->brand = $brand;
    }
    /**
     * Display a listing of the resource. type
     */
    public function index(Request $request)
    {
        $brandRepository = New BrandRepository($this->brand);

        if($request->has('params_type')){
            $params_type = 'types:id,'.$request->params_type;
            $brandRepository->selectAttributesRelatedRegisters($params_type);
        }else{
            $brandRepository->selectAttributesRelatedRegisters('types');
        }

        if($request->has('filter')){
            $brandRepository->filter($request->filter);
        }
        if($request->has('params')){
            $brandRepository->selectAttributes($request->params);
        }

        $brands = $brandRepository->getResultPaginated(3);

        if($brands === null){
            return response()->json(['erro' => 'Nenhum registro encontrado'],404);
        }
        return response()->json($brands,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->brand->rules(), $this->brand->feedback());
        
        //Image store
        $image = $request->file('image');
        $image_urn = $image->store('files','public');

        $brand = $this->brand->create([
            'name' => $request->name,
            'image' => $image_urn,
        ]);

        return response()->json($brand,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {         
        $brand = $this->brand->with('types')->find($id);
        if($brand === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }
        return response()->json($brand,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$brand->update($request->all());

        $brand = $this->brand->find($id);
        if($brand === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            if($request->method() == 'PATCH'){
                $dynamicRules = array();
                foreach($brand->rules() as $input => $rule){
                    if(array_key_exists($input, $request->all())){
                        $dynamicRules[$input] = $rule;
                    }
                }
                $request->validate($dynamicRules, $brand->feedback());
            }else{
                $request->validate($brand->rules(), $brand->feedback());
            }

            $brand->fill($request->all());
            if($request->file('image')){
                Storage::disk('public')->delete($brand->image);
                $image = $request->file('image');
                $image_urn = $image->store('files','public');
                $brand->image = $image_urn;
            }
            $brand->save();
            return response()->json($brand,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $brand = $this->brand->find($id);
        if($brand === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            Storage::disk('public')->delete($brand->image);
            $brand->delete();
            return response()->json(['msg' => 'Registro removido com sucesso!'],200);
        }        
    }
}
