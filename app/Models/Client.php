<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable  = ['name'];

    public function rules(){
        return [
            'name' => 'required',
        ];
    }
    public function feedback(){
        return [];
    }
    
}
