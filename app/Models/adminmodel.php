<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class adminmodel extends  Authenticatable
{
    // protected $guard = 'admin';
    protected $table = "admins";
    protected $fillable = [
        'name',
        'email',
        'password',
        'parent_id',
        'status_admin',
    ];

    public static function create($data){
        $admindata = [
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => $data['password'],
            'parent_id'=> $data['parent_id'],
            'status_admin' =>$data['status'],
        ];
        
        $admin = new adminmodel($admindata);
        if ($admin->save()) {
            return $admin;
        } else {
           
            return false;
        }
    }
   
    
    
    
    public static function updateadmin($request, $id) {
        $admin = adminmodel::find($id);
        if ($admin) {
            $admin->update(['name' => $request['admin_name']]);
            $admin->update(['email' => $request['admin_email']]);
            $admin->update(['passowrd' => $request['password']]);
            return $admin;
        }
        return null; 
    }

    public function parent()
    {
        return $this->belongsTo(AdminModel::class, 'parent_id');
    }

    // Optionally, define a relationship for child admins
    public function children()
    {
        return $this->hasMany(AdminModel::class, 'parent_id');
    }

    
    
    use HasFactory;
}
