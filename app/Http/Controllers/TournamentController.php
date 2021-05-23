<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    public function index()
    {
        $details = DB::table('game_schedule')
                    ->select(
        'team_1.country as team_1_country', 
        'team_2.country as team_2_country', 
        'team_1.team_name as team_name_1', 
        'team_2.team_name as team_name_2', 
        'team_1.photo_url as team_1_photo', 
        'team_2.photo_url as team_2_photo', 
        'game_schedule.date', 
        'game_schedule.time', 
        'game_schedule.is_in_progress', 
        'game_schedule.is_upcoming')
                    ->join('user as team_1', 'team_1.id', 'game_schedule.player_1')
                    ->join('user as team_2', 'team_2.id', 'game_schedule.player_2')
                    ->where('game_schedule.player_1', Auth::id())
                    ->orWhere('game_schedule.player_2', Auth::id())
                    ->get();
        return view('tournament', ['details' => $details]);
    }
}
