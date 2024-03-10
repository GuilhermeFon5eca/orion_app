<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name','image'];

    public function rules(){
        return [
            'name' => 'required|unique:brands,name,'.$this->id,
            'image' => 'required|file|mimes:png'
        ];
    }
    public function feedback(){
        
        return [];
    }

    public function types(){
        return $this->hasMany('App\Models\Type');
    }
}
