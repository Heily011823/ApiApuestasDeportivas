<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odd extends Model
{
    use HasFactory;

    protected $table = 'odds';

    protected $fillable = [
        'event_id',
        'bet_type',
        'odd_value'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}