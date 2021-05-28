<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamController extends Controller
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
    public function index(){
        $data = Team::select('name')->get();
        return response()->json($data);
    }

    public function create()
    {
        return view('admin.team.create');
    }

    private function validateTeam()
    {
        return request()->validate([
            'name' => 'required|max:255|unique:teams,name,NULL,id,user_id,'.auth()->id(),
            'coach' => 'required|max:255|unique:teams,coach,NULL,id,user_id,'.auth()->id(),
            'location' => 'required|max:255'
        ]);
    }

    public function store()
    {
        request()->user()->teams()->create($this->validateTeam());
        return redirect()->route('admin');
    }

    private function getMatches($team)
    {
        $home_matches = $team->home_matches()->get();
        $away_matches =$team->away_matches()->get();
        $matches = $home_matches->merge($away_matches);
        $matches = $matches->sort(function($a, $b) {
            if($a->date_played === $b->date_played) {
              if($a->created_at === $b->created_at) return 0;
              return $a->created_at < $b->created_at ? -1 : 1;
            } 
            return $a->date_played < $b->date_played ? -1 : 1;
        });

        return $matches;
    }

    public function show(Team $team)
    {
        $players = $team->players()->get();

        $matches = $this->getMatches($team);

        return view('admin.team.show', [
            'team' => $team,
            'players' => $players,
            'matches' => $matches->reverse(),
        ]);
    }

    public function edit(Team $team)
    {
        $this->authorize('update', $team);
        return view('admin.team.edit', ['team' => $team]);
    }

    public function update(Team $team)
    {
        $this->authorize('update', $team);
        $team->update($this->validateTeam());
        return redirect()->route('team.show', $team);
    }
}
