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

    public function inputFields(){
        return [
            'config_website_name' => [
                'title' => 'Nome do site',
                'type' => 'text',
                'size' => 50,
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],
            'config_logo' => [
                'title' => 'Logo',
                'type' => 'file', 
                'size' => 50,
                'show_at_search' => false,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-12 mb-3'
            ],
            // 'config_logo' => [
            //     'title' => 'Logo',
            //     'type' => 'text', 
            //     'size' => 50,
            //     'show_at_search' => true,
            //     'show_at_insert' => true,
            //     'show_at_show' => true,
            //     'class' => 'col-4 mb-3'
            // ],
            'config_entry' => [
                'title' => 'Entrada',
                'type' => 'select', 
                'size' => 50,
                'select_fields' =>[
                    ['name'=>'Pública','value' => 'public'],
                    ['name'=>'Restrita','value' => 'restrict'],
                ],
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],
            'config_account_creation' => [
                'title' => 'Status padrão de Conta',
                'type' => 'select',
                'size' => 50,
                'select_fields' =>[
                    ['name'=>'Restrito','value' => 'restrict'],
                    ['name'=>'Conf. Email','value' => 'conf_email'],
                    ['name'=>'Permitido','value' => 'allowed'],
                    ['name'=>'Sem Denúncias','value' => 'no_denounces'],
                    ['name'=>'Suspenso','value' => 'suspended'],
                    ['name'=>'Banido','value' => 'banned'],
                ],
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],
            'config_clock' => [
                'title' => 'Pool Padrão',
                'type' => 'select', 
                'size' => 50,
                'select_fields' =>[
                    ['name'=>'5 segundos','value' => 5],
                    ['name'=>'10 segundos','value' => 10],
                    ['name'=>'20 segundos','value' => 20],
                    ['name'=>'30 segundos','value' => 30],
                    ['name'=>'60 segundos','value' => 60],
                    ['name'=>'120 segundos','value' => 120],
                    ['name'=>'300 segundos','value' => 300],
                ],
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],
            'config_profile_limit' => [
                'title' => 'Limite de Perfis',
                'type' => 'number', 
                'size' => 11,
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],
            'config_profile_drive_limit' => [
                'title' => 'Limite de Perfis Drive',
                'type' => 'text', 
                'size' => 50,
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],
            'config_admin_mail' => [
                'title' => 'Email Admin',
                'type' => 'text', 
                'size' => 50,
                'show_at_search' => true,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-4 mb-3'
            ],           
            'config_textarea' => [
                'title' => 'TEXTAREA',
                'type' => 'textarea', 
                'size' => 50,
                'show_at_search' => false,
                'show_at_insert' => true,
                'show_at_show' => true,
                'class' => 'col-12 mb-3'
            ],
        ];
    }
}
