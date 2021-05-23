<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeamSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class RegistrationController extends Controller
{
    public function registrationPage()
    {
        return view('registration.index');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:user|max:255',
            'photo' => 'required',
            'team_coach' => 'required',
            'team_name' => 'required|unique:user',
        ]);

        if ($validator->fails()) {
            return redirect('register/')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $location = Location::get($request->ip());
        $request['country'] = $location->countryName ?? '';
        $request['name'] = '';
        $request['photo_url'] = $request['pic_url'];
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->all());
        for ($e = 1; $e <= 24; $e++) {
            $request['time'] = $e.':00';
            $request['user_id'] = $user->id;
            TeamSchedule::create($request->all());
        }
        return redirect()->back()->with('message', 'Congratulations! You are successfuly registered. You can now login');
    }

    public function teamLogoUpload(Request $request)
    {
        $request = request()->all();
        $icon = $request['photo'];
        $destination = public_path('assets/app/img/');
        $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());
        $icon->move($destination, $icon->getClientOriginalName());
        return response()->json($icon_url);
    }
}
