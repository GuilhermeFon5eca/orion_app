<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigRepository;
use Illuminate\Support\Facades\Storage;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    public function __construct(Config $config){
        $this->config = $config;
    }
    /**
     * Display a listing of the resource. type
     */
    public function index(Request $request)
    {
        $configRepository = New ConfigRepository($this->config);

        if($request->has('params_type')){
            $params_type = 'types:id,'.$request->params_type;
            $configRepository->selectAttributesRelatedRegisters($params_type);
        }else{
            $configRepository->selectAttributesRelatedRegisters('types');
        }

        if($request->has('filter')){
            $configRepository->filter($request->filter);
        }
        if($request->has('params')){
            $configRepository->selectAttributes($request->params);
        }

        $configs = $configRepository->getResultPaginated(3);

        if($configs === null){
            return response()->json(['erro' => 'Nenhum registro encontrado'],404);
        }
        return response()->json($configs,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate($this->config->rules(), $this->config->feedback());
        
        //Image store
        $image = $request->file('image');
        $image_urn = $image->store('files','public');

        $config = $this->config->create([
            'name' => $request->name,
            'image' => $image_urn,
        ]);

        return response()->json($config,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {         
        $config = $this->config->with('types')->find($id);
        if($config === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }
        return response()->json($config,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$config->update($request->all());

        $config = $this->config->find($id);
        if($config === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            if($request->method() == 'PATCH'){
                $dynamicRules = array();
                foreach($config->rules() as $input => $rule){
                    if(array_key_exists($input, $request->all())){
                        $dynamicRules[$input] = $rule;
                    }
                }
                $request->validate($dynamicRules, $config->feedback());
            }else{
                $request->validate($config->rules(), $config->feedback());
            }

            $config->fill($request->all());
            if($request->file('image')){
                Storage::disk('public')->delete($config->image);
                $image = $request->file('image');
                $image_urn = $image->store('files','public');
                $config->image = $image_urn;
            }
            $config->save();
            return response()->json($config,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $config = $this->config->find($id);
        if($config === null){
            return response()->json(['erro' => 'Registro não encontrado'],404);
        }else{
            Storage::disk('public')->delete($config->image);
            $config->delete();
            return response()->json(['msg' => 'Registro removido com sucesso!'],200);
        }        
    }
}
