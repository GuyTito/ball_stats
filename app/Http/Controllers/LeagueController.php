<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = User::all();
        return view('home', ['leagues' => $leagues]);
    }
    
    private function sumGoalsAssists($collection, $model, $season)
    {
        $processed = collect([]);
        foreach ($collection as $item){
            $relation = $model == 'goals' ? $item->player->goals : $item->player->assists;
            
            $processed-> push(collect([
                'name' => $item->player->name,
                'team' => $item->player->team->name,
                $model => $relation->whereIn('season_id', $season->id)->sum($model),
            ]));
        }
        return $processed;
    }

    private function createStandings($teams, $season_id)
    {
        $standings = collect([]);
        foreach ($teams as $team){
            $matches_played = $team->home_matches()->where('season_id', $season_id)->count() + $team->away_matches()->where('season_id', $season_id)->count();
            $wins = $team->win_matches()->where('season_id', $season_id)->count();
            $losses = $team->loss_matches()->where('season_id', $season_id)->count();
            $draws = $matches_played - $wins - $losses;
            $points = ($wins * 3) + $draws;
            $goals_scored = $team->home_matches()->where('season_id', $season_id)->sum('home_team_score') + $team->away_matches()->where('season_id', $season_id)->sum('away_team_score');
            $goals_conceded = $team->home_matches()->where('season_id', $season_id)->sum('away_team_score') + $team->away_matches()->where('season_id', $season_id)->sum('home_team_score');

            $standings-> push(collect([
                'name' => $team->name,
                'mp' => $matches_played,
                'w' => $wins,
                'l' => $losses,
                'd' => $draws,
                'pts' => $points,
                'gs' => $goals_scored,
                'gc' => $goals_conceded,
            ]));
        }

        return $standings;
    }

    public function show(User $user)
    {
        if( request()->has('season') && $user->seasons()->find(request()->query('season')) ) {
            $season_id = (int)request()->query('season');
        } else {
            $season_id = $user->seasons()->latest()->first()->id;
        }
        
        $seasons  = $user->seasons()->latest()->get();
        $current_season = $user->seasons()->find($season_id);
        
        $matches = $user->match_events()->latest('date_played')->where('season_id', $season_id)->get();
        $goals = $current_season->goals()->select('player_id')->distinct()->get();
        $assists =  $current_season->assists()->select('player_id')->distinct()->get();
        
        $goals = $this->sumGoalsAssists($goals, 'goals', $current_season);     
        $assists = $this->sumGoalsAssists($assists, 'assists', $current_season);     
        
        $teams = $user->teams()->get();

        $standings = $this->createStandings($teams, $season_id);

        return view('league', [
            'league' => $user,
            'seasons' => $seasons,
            'current_season' => $current_season,
            'matches' => $matches,
            'goals' => $goals->sortByDesc('goals'),
            'assists' => $assists->sortByDesc('assists'),
            'standings' => $standings,
        ]);
    }
    

    
    public function matches()
    {
        return view('matches');    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
