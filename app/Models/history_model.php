<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history_model extends Model
{
  

    protected $table = "history";
    protected $fillable = [ 
           'assign_admin',
           'ticket_id',
           'user_id',          
           'date',          
           'status',
           'parent_id',
    ];
    use HasFactory;
}
