<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;

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
        return view('admin.player.create', [
            'teams' => Team::where('user_id', auth()->id())->get()
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
        // dd($this->validatePlayer());
        request()->user()->players()->create($this->validatePlayer());

        return redirect()->route('admin');

    }

    public function getPlayers(){

        $players = request()->user()->players()->select('name')->get();
   
        return response()->json($players);
    }
}
