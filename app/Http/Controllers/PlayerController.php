<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Carbon\Carbon;

class PlayerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'])->only(['create','store','edit','update','destroy']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $players = request()->user()->players()->select('name')->get();
        return response()->json($players);
    }

    
    public function create()
    {
        return view('admin.player.create', [
            'teams' => Team::where('user_id', auth()->id())->get()
        ]);
    }

    private function seasonalStats($seasons, $player, $column)
    {
        $seasonalStats = collect([]);
        foreach ($seasons as $season) {
            $season_string = Carbon::parse($season->start_date)->toFormattedDateString() . ' - ' . Carbon::parse($season->end_date)->toFormattedDateString();
            $model = $column == 'goals' ? $player->goals : $player->assists;
            $seasonalStats->push(collect([
                $season_string => $model->whereIn('season_id', $season->id)->sum($column)
            ]));
        }

        return $seasonalStats;
    }

    public function show(Player $player)
    {
        $seasons = ($player->user->seasons)->reverse();

        $seasonalGoals = $this->seasonalStats($seasons, $player, 'goals');
        $seasonalAssists = $this->seasonalStats($seasons, $player, 'assists');

        return view('admin.player.show', [
            'player' => $player,
            'goals' => $seasonalGoals,
            'assists' => $seasonalAssists,
        ]);
    }

    private function validatePlayer()
    {
        return request()->validate([
            'name' => 'required|max:255|unique:players,name,NULL,id,user_id,'.auth()->id(),
            'team_id' => 'required|exists:teams,id',
            'position' => 'max:255',
            'birth_date' => 'date|before:yesterday',
        ],
        [
            'team_id.exists' => 'Select a team'
        ]);
            
        
    }

    public function store()
    {
        request()->user()->players()->create($this->validatePlayer());
        return redirect()->route('admin');
    }

    public function edit(Player $player)
    {
        $this->authorize('update', $player);
        return view('admin.player.edit', [
            'player' => $player,
            'teams' => Team::where('user_id', auth()->id())->get()
        ]);
    }

    public function update(Player $player)
    {
        $this->authorize('update', $player);
        $player->update($this->validatePlayer());
        return redirect()->route('player.show', $player);
    }
}
