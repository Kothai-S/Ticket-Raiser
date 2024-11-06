<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCommentModel extends Model
{
    protected $table ="_ticketcomments";
    protected $fillable = [
        'ticket_id',
        'comments',
        'ticket_reason',
        'assign_person',
       
        
    ];
    use HasFactory;
}
