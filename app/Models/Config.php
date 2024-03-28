<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $fillable = ['config_website_name', 'config_logo', 'config_entry', 'config_account_creation', 'config_clock',  'config_profile_limit', 'config_profile_drive_limit', 'config_admin_mail'];

    public function rules(){
        return [
            'config_website_name' => 'required',
            'config_logo' => 'required|file|mimes:png,jpg,jpeg',
            'config_entry' => 'required',
            'config_account_creation' => 'required',
            'config_clock' => 'required',
            'config_profile_limit' => 'required',
            'config_profile_drive_limit' => 'required',
            'config_admin_mail' => 'required',
        ];
    }
    public function feedback(){
        
        return [];
    }
}
