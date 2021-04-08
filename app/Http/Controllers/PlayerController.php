<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.player.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'team' => 'required|max:255',
            'position' => 'max:255',
            'birth_date' => 'date|before:yesterday',
        ]);

        $team = $request->team;

        $team = Team::where('name', $request->team);

        // select id, name from team where name = $request->team

        dd([ $request->name, $request->position, $request->birth_date, $team->name ]);

        // $request->user()->players()->create([
        //     'name' => $request->name,
        //     'position' => $request->position,
        //     'birth_date' => $request->birth_date,
        //     'team_id' => $request->team()->id
        // ]);

        // return back();
    }
}
