<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticketreasonmodel extends Model
{
    protected $table ="ticket_reasons";
    protected $fillable = [
        'reason',
        'instruction',
        'category',
    ];
    use HasFactory;

    public static function createreason($data){

        $parent_id = isset($data['parent_id']) ? $data['parent_id'] : 0;
    
        $reasondata = [
            'reason' => $data['reason'],
            'instruction' => $data['instruction'],
            'category' => $parent_id,
        ];
        
        $reasonticket = new ticketreasonmodel($reasondata);
        if ($reasonticket->save()) {
            return $reasonticket;
        } else {
            return false;
        }
    }
    
    public static function create($data){
        $ticketdata = [
            'reaon' => $data['reason'],
            
        ];
        
        $reason = new ticketreasonmodel($ticketdata);
        if ($reason->save()) {
            return $reason;
        } else {
           
            return false;
        }
    }
    
    public function parent()
    {
        return $this->belongsTo(ticketreasonmodel::class, 'category');
    }

    // Optionally, define a relationship for child admins
    public function children()
    {
        return $this->hasMany(ticketreasonmodel::class, 'category');
    }


}