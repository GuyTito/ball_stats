<?php

namespace App\Http\Controllers;

use App\Models\Assists;
use App\Models\Goals;
use App\Models\MatchEvent;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $validatedData = $request->validate( [
            'season' => 'required|exists:seasons,id',
            'date_played' => 'required|date|before:tomorrow',
            'team_A' => 'required|string|exists:teams,name',
            'team_B' => 'required|string|exists:teams,name|different:team_A',
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
            'scorers.*.distinct' => 'Goal scorer must appear once',
            'scorers.*.string' => 'Player Name does not exist in Database',
            'scorers.*.exists' => 'Player Name does not exist in Database',
            'assistors.*.distinct' => 'Assist provider must appear once',
            'assistors.*.string' => 'Player Name does not exist in Database',
            'assistors.*.exists' => 'Player Name does not exist in Database',
            'team_A.exists' => 'Team Name does not exist in Database',
            'team_B.exists' => 'Team Name does not exist in Database',
        ]);

        // compare sum of scores with sum of goals and that of assists
        $goalsSum = collect($request->input('goals'))->sum();
        $assistsSum = collect($request->input('assists'))->sum();
        $scoreSum = $request->team_A_score + $request->team_A_score;
        if ($goalsSum > $scoreSum) {
            return back()->withErrors(['scorers.*' => 'Goals scored cannot be more than match score'])->withInput();
        }
        if ($assistsSum > $scoreSum) {
            return back()->withErrors(['assistors.*' => 'Assists provided cannot be more than match score'])->withInput();
        }

        DB::beginTransaction();
        try{
            $justInserted = MatchEvent::create($validatedData);

            $countScorers = collect($request->scorers)->count();
            for ($x = 0; $x < $countScorers; $x++)
            {
                Goals::create([
                    'player_id' => Player::where('name', $request->scorers[$x])->first()->id,
                    'goals' => $request->goals[$x],
                    'match_id' => $justInserted->id
                ]);
            }

            $countAssistors = collect($request->assistors)->count();
            for ($x = 0; $x < $countAssistors; $x++)
            {
                Assists::create([
                    'player_id' => Player::where('name', $request->assistors[$x])->first()->id,
                    'goals' => $request->assists[$x],
                    'match_id' => $justInserted->id
                ]);
            }

            DB::commit();

            return redirect()->route('admin');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['notInserted' => $e->getMessage()])->withInput();
        }
    }
}
