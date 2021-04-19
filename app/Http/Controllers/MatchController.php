<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
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
        return view('admin.match.create', [
            'seasons' => Season::latest()->where('user_id', Auth::id())->get(),
            'teams' => Team::where('user_id', Auth::id())->get()
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'season' => 'required|exists:seasons,id',
            'date_played' => 'required|date|before:tomorrow',
            'team_A' => 'required|string|exists:teams,name',
            'team_B' => 'required|string|exists:teams,name',
            'team_A_score' => 'required|min:0',
            'team_B_score' => 'required|min:0',
            'scorers' => 'array',
            'scorers.*' => 'string|distinct|exists:players,name',
            'goals' => 'array',
            'goals.*' => 'integer|min:1',
            'assistors' => 'array',
            'assistors.*' => 'string|distinct|exists:players,name',
            'assists' => 'array',
            'assists.*' => 'integer|min:1',
            'referee' => 'max:255',
            'venue' => 'max:255',
        ],
        [
            'scorers.*.exists' => 'Player Name does not exist in Database',
            'assistors.*.exists' => 'Player Name does not exist in Database',
            'team_A.exists' => 'Team Name does not exist in Database',
            'team_B.exists' => 'Team Name does not exist in Database',
        ]);

        dd($request->post());

        // $team = Team::find($request->team);

        // $team->players()->create([
        //     'name' => $request->name,
        //     'position' => $request->position,
        //     'birth_date' => $request->birth_date,
        //     'team_id' => $team->id
        // ]);

        return redirect()->route('admin');
    }
}
