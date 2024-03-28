<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model; 

class AbstractRepository{
    public function __construct(Model $model){
        $this->model = $model;
    }

    public function selectAttributesRelatedRegisters($attributes){
        $this->model = $this->model->with($attributes);
    }
    
    public function filter($filter){
        $filters = explode(';',$filter);
        foreach($filters as $conditions){
            $c = explode(':',$conditions);
            if(in_array($c[1], ['like','where', '=','>','<','>=','=<','=='])){
                $this->model = $this->model->where($c[0],$c[1],$c[2]);
            }
        }
    }

    public function selectAttributes($params){
        $this->model = $this->model->selectRaw($params);
    }

    public function getResult(){
        return $this->model->get();
    }
    public function getResultPaginated(int $numberOfRegistries){
        return $this->model->paginate($numberOfRegistries);
    }
}
