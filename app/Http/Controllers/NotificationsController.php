<?php

namespace App\Http\Controllers;

use App\Models\GameSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $details = DB::table('game_schedule')
            ->select('player_1.team_name as team_1', 'player_2.team_name as team_2', 'game_schedule.id', 'game_schedule.time', 'game_schedule.date')
            ->join('user as player_1', 'player_1.id', 'game_schedule.player_1')
            ->join('user as player_2', 'player_2.id', 'game_schedule.player_2')
            ->where('game_schedule.player_2', Auth::id())
            ->where('game_schedule.is_approve', 0)
            ->get();
        return view('dashboard.users.notifications', ['details' => $details]);
    }

    public function acceptInvitation($id)
    {
        $currentDateTime = strtotime(date('Y-m-d h:i'));
        $getDatetime = DB::table('game_schedule')->select('string_time')->where('id', $id)->first();
        if ($currentDateTime > $getDatetime->string_time) {
            DB::update('update game_schedule set is_in_progress = 1, is_approve = 1 where id = ?', [$id]);
        }

        if($currentDateTime < $getDatetime->string_time) {
            DB::update('update game_schedule set is_approve = 1, is_upcoming = 1, is_in_progress = 0 where id = ?', [$id]);
        }

        return redirect()->back()->with('message', 'Invitation accepted!');
    }
}
