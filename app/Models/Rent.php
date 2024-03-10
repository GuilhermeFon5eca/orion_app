<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    // protected $table = 'someothertable';
    protected $fillable = [
        'client_id',
        'car_id',
        'data_start_rent',
        'data_foreseen_end_rent',
        'data_end_rent',
        'daily_rate',
        'km_initial',
        'km_final'
    ];
    public function rules(){
        return [];
    }
    public function feedback(){
        return [];
    }
}
