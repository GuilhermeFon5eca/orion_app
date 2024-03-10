<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id','name','image','doors_number','seats','air_bag','abs'];

    public function rules(){
        return [
            'brand_id' => 'exists:brands,id',
            'name' => 'required|unique:types,name,'.$this->id,
            'image' => 'required|file|mimes:png,jpeg,jpg',
            'doors_number' => 'required|integer|digits_between:1,5',
            'seats' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }
    public function feedback(){
        return [];
    }
    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }
}
