<?php

namespace App\Http\Controllers;

use App\Models\Assists;
use App\Models\Goals;
use App\Models\MatchEvent;
use App\Models\Season;
use App\Models\Team;
use Carbon\Carbon;

class MatchEventController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth'])->only(['create', 'store', 'edit', 'update', 'destroy']);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function create()
  {
    return view('admin.match.create', [
      'seasons' => Season::latest()->where('user_id', auth()->id())->get(),
      'teams' => Team::where('user_id', auth()->id())->get()
    ]);
  }

  private function validateMatch()
  {
    return request()->validate(
      [
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
        'scorers.*.string' => 'Player(s) not in this league.',
        'scorers.*.exists' => 'Player(s) not in this league.',
        'assistors.*.distinct' => 'Assist provider must appear once.',
        'assistors.*.string' => 'Player(s) not in this league.',
        'assistors.*.exists' => 'Player(s) not in this league.',
        'home_team_id.exists' => 'Select a team',
        'away_team_id.exists' => 'Select a team',
      ]
    );
  }

  private function checkMatchDateBetweenSeasonDates()
  {
    $season = Season::find(request()->season_id);
    $season_start = Carbon::createFromDate($season['start_date']);
    $season_end = Carbon::createFromDate($season['end_date']);
    $match_date = Carbon::createFromDate(request()->date_played);
    if ($match_date->lt($season_start) or $match_date->gt($season_end)) {
      return back()->withErrors(['date_played' => 'Match date must be between the start and end of the season'])->withInput();
    }
  }

  private function validateScoreAssistSum()
  {
    // compare sum of scores with sum of goals and that of assists
    $goalsSum = collect(request()->input('goals'))->sum();
    $assistsSum = collect(request()->input('assists'))->sum();
    $scoreSum = request()->home_team_score + request()->away_team_score;
    if ($goalsSum > $scoreSum) {
      return back()->withErrors(['scorers.*' => 'Goals scored cannot be more than match score'])->withInput();
    }
    if ($assistsSum > $scoreSum) {
      return back()->withErrors(['assistors.*' => 'Assists provided cannot be more than match score'])->withInput();
    }
  }

  private function addWinLossTeam($results)
  {
    if (request()->home_team_score > request()->away_team_score) {
      $win_team_id = request()->home_team_id;
      $loss_team_id = request()->away_team_id;
    } elseif (request()->away_team_score > request()->home_team_score) {
      $win_team_id = request()->away_team_id;
      $loss_team_id = request()->home_team_id;
    } else {
      $win_team_id = null;
      $loss_team_id = null;
    }

    $win_loss_team = ['win_team_id' => $win_team_id, 'loss_team_id' => $loss_team_id];

    $results = array_merge($results, $win_loss_team);

    return $results;
  }

  private function saveGoalsAssists($action, $counter, $model, $request_1, $request_2, $field, $last_id)
  {
    if ($action == 'update') {
      $model->where('match_id', $last_id->id)->delete();
    }

    for ($i = 0; $i < $counter; $i++) {
      $model->create([
        'season_id' => request('season_id'),
        'player_id' => request()->user()->players()->where('name', $request_1[$i])->first()->id,
        $field => $request_2[$i],
        'match_id' => $last_id->id
      ]);
    }
  }

  public function store()
  {
    $cmdbsd = $this->checkMatchDateBetweenSeasonDates();
    if ($cmdbsd) return $cmdbsd;

    $vsa = $this->validateScoreAssistSum();
    if ($vsa) return $vsa;

    $match_results = $this->addWinLossTeam($this->validateMatch());

    $match_stored = request()->user()->match_events()->create($match_results);

    $countScorers = collect(request()->scorers)->count();
    $this->saveGoalsAssists('store', $countScorers, request()->user()->goals(), request()->scorers, request()->goals, 'goals', $match_stored);

    $countAssistors = collect(request()->assistors)->count();
    $this->saveGoalsAssists('store', $countAssistors, request()->user()->assists(), request()->assistors, request()->assists, 'assists', $match_stored);

    return redirect()->route('match.show', $match_stored);
  }

  private function matchStats($models, $column)
  {
    $match_stats = collect([]);
    foreach ($models as $model) {
      $stat = $column == 'goals' ? $model->goals : $model->assists;
      $match_stats->push(collect([
        $model->player->name => [$model->player, $stat]
      ]));
    }

    return $match_stats;
  }

  public function show(MatchEvent $match)
  {
    $goals = Goals::where('match_id', $match->id)->get();
    $assists = Assists::where('match_id', $match->id)->get();

    $match_goals = $this->matchStats($goals, 'goals');
    $match_assists = $this->matchStats($assists, 'assists');

    return view('admin.match.show', [
      'match' => $match,
      'match_goals' => $match_goals,
      'match_assists' => $match_assists,
    ]);
  }

  public function edit(MatchEvent $match)
  {
    $this->authorize('update', $match);

    $goals = Goals::where('match_id', $match->id)->get();
    $assists = Assists::where('match_id', $match->id)->get();

    $match_goals = $this->matchStats($goals, 'goals');
    $match_assists = $this->matchStats($assists, 'assists');

    return view('admin.match.edit', [
      'match' => $match,
      'match_goals' => $match_goals,
      'match_assists' => $match_assists,
      'seasons' => Season::latest()->where('user_id', auth()->id())->get(),
      'teams' => Team::where('user_id', auth()->id())->get()
    ]);
  }

  public function update(MatchEvent $match)
  {
    $this->authorize('update', $match);

    $cmdbsd = $this->checkMatchDateBetweenSeasonDates();
    if ($cmdbsd) return $cmdbsd;

    $vsa = $this->validateScoreAssistSum();
    if ($vsa) return $vsa;

    $match_results = $this->addWinLossTeam($this->validateMatch());

    $match->update($match_results);

    $countScorers = collect(request()->scorers)->count();
    $this->saveGoalsAssists('update', $countScorers, request()->user()->goals(), request()->scorers, request()->goals, 'goals', $match);

    $countAssistors = collect(request()->assistors)->count();
    $this->saveGoalsAssists('update', $countAssistors, request()->user()->assists(), request()->assistors, request()->assists, 'assists', $match);

    return redirect()->route('match.show', $match);
  }

  public function destroy(MatchEvent $match)
  {
    $this->authorize('delete', $match);
    $match->destroy($match->id);
    return redirect()->route('league', $match->user);
  }
}
