<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_raise extends Model
{
    

    protected $table ="ticket_raises";
    protected $fillable = [
        'userid',
        'category_id',
        'reason',
        'image',
        'link',
        'current_date',
        'status',       
        
    ];
    use HasFactory;
}
