<?php

namespace App\Http\Controllers;

use App\Models\GameSchedule;
use App\Models\User;
use App\Models\TeamSchedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function homePage()
    {
        return view('index');
    }
    public function index()
    {
        $users = DB::table('user')
            ->distinct('user.team_name', 'user.photo_url', 'user.team_coach', 'user.country')
            ->select('user.team_name', 'user.id', 'user.photo_url', 'user.team_coach', 'user.country', 'user.id as team_id')
            ->where('user.id', '<>', Auth::id())
            ->get();

        return view('dashboard.users.index', ['users' => $users]);
    }

    public function teamPage()
    {
        return view('dashboard.users.team');
    }

    public function teamInformationPage()
    {
        $details = DB::table('team_schedule')->select('time')->where('user_id', Auth::id())->get();
        return view('dashboard.users.teamInformation', ['details' => $details]);
    }

    public function updateUser()
    {
        return 0;
    }

    public function createTeamSchedule()
    {
        $request = request()->all();
        $validator = Validator::make($request, [
            'time' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('user/information')
                        ->withErrors($validator)
                        ->withInput();
        }
        TeamSchedule::create($request);
        return redirect()->back()->with('message1', 'You are successfully create a schedule');
    }

    public function sendBattleRequest()
    {
        $request = request()->all();
        $validator = Validator::make($request, [
            'player_1' => 'required',
            'player_2' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('user')
                        ->withErrors($validator)
                        ->withInput();
        }

        $request['string_time'] = strtotime($request['date']. ' '.$request['time']);
        $request['is_approve'] = 0;
        $request['is_upcoming'] = 0;
        $request['is_in_progress'] = 0;
        GameSchedule::create($request);
        return redirect()->back()->with('message1', 'You are successfully create a battle request.');
    }
}
