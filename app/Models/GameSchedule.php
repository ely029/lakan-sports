<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSchedule extends Model
{
    protected $table = 'game_schedule';

    protected $fillable = [
        '_token',
        'player_1',
        'player_2',
        'time',
        'date',
        'string_time',
        'is_approve',
        'is_upcoming',
        'is_in_progress',
    ];
}