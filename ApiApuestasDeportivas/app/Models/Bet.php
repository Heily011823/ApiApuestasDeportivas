<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = [
        'user_id',       
        'event_id',      
        'tipo_apuesta',  
        'amount',        
        'odds',          
        'potential_win', 
        'status' 
    ];

    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function event(){
        
        return $this->belongsTo(Event::class, 'event_id');
    }
}
