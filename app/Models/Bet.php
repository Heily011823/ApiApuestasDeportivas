<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'odds',
        'potential_win',
        'status'
    ];
}
