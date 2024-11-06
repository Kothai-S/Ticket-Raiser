<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;


class usermodel extends Authenticatable
{
    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'password',
        'status_user',
        
    ];
    use HasFactory;

    public static function add($data){
        $userdata = [
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'password' => $data['password'],
            'status_user' => $data['status'],
        ];
        
        $user = new usermodel($userdata);
        if ($user->save()) {
            return $user;
        } else {
           
            return false;
        }
    }

    

}