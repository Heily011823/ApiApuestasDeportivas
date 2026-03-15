<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'outcome',
    ];

    public function event(){

        return $this->belongsTo(Event::class, 'event_id');
    }

    public function bets(){
        
        return $this->hasMany(Bet::class, 'event_id');
    }
}