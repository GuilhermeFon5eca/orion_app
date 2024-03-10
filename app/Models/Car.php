<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['type_id','plate','available','km'];

    public function rules(){
        return [
            'type_id' => 'exists:types,id',
            'plate' => 'required',
            'available' => 'required',
            'km' => 'required',
        ];
    }
    public function feedback(){
        return [];
    }
    public function type(){
        return $this->belongsTo('App\Models\Type');
    }
}
