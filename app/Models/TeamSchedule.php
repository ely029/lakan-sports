<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSchedule extends Model
{
    protected $table = 'team_schedule';

    protected $fillable = [
        'user_id',
        'time',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
}
