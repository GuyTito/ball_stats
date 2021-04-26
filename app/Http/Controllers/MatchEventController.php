<?php

namespace App\Http\Controllers;

use App\Models\Assists;
use App\Models\Goals;
use App\Models\MatchEvent;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;

class MatchEventController extends Controller
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
            'seasons' => Season::latest()->where('user_id', auth()->id())->get(),
            'teams' => Team::where('user_id', auth()->id())->get()
        ]);
    }

    private function validateMatch()
    {
        return request()->validate( [
            'season_id' => 'required|exists:seasons,id',
            'date_played' => 'required|date|before:tomorrow',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'home_team_score' => 'required|min:0',
            'away_team_score' => 'required|min:0',
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
            'away_team_id.different' => 'The away team and home team must be different.',
            'scorers.*.distinct' => 'Goal scorer must appear once',
            'scorers.*.string' => 'Player Name does not exist in Database',
            'scorers.*.exists' => 'Player Name does not exist in Database',
            'assistors.*.distinct' => 'Assist provider must appear once',
            'assistors.*.string' => 'Player Name does not exist in Database',
            'assistors.*.exists' => 'Player Name does not exist in Database',
            'home_team_id.exists' => 'Select a team',
            'away_team_id.exists' => 'Select a team',
        ]);
    }

    private function validateScoreAssistSum()
    {
        // compare sum of scores with sum of goals and that of assists
        $goalsSum = collect(request()->input('goals'))->sum();
        $assistsSum = collect(request()->input('assists'))->sum();
        $scoreSum = request()->home_team_score + request()->home_team_score;
        if ($goalsSum > $scoreSum) {
            return back()->withErrors(['scorers.*' => 'Goals scored cannot be more than match score'])->withInput();
        }
        if ($assistsSum > $scoreSum) {
            return back()->withErrors(['assistors.*' => 'Assists provided cannot be more than match score'])->withInput();
        }
    }

    private function storeGoalsAssists($counter, $model, $request_1, $request_2, $field, $last_id)
    {
        for ($i = 0; $i < $counter; $i++)
        {
            $model::create([
                'player_id' => Player::where('name', $request_1[$i])->first()->id,
                $field => $request_2[$i],
                'match_id' => $last_id->id
            ]);
        }
    }

    public function store()
    {
        $this->validateScoreAssistSum();
        $justInserted = MatchEvent::create($this->validateMatch());

        $countScorers = collect(request()->scorers)->count();
        $this->storeGoalsAssists($countScorers, Goals::class, request()->scorers, request()->goals, 'goals', $justInserted);

        $countAssistors = collect(request()->assistors)->count();
        $this->storeGoalsAssists($countAssistors, Assists::class, request()->assistors, request()->assists, 'assists', $justInserted);

        return redirect()->route('admin');
    }
}
