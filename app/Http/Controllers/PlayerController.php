<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'teams' => Team::where('user_id', Auth::id())->get()
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'team' => 'exists:teams,id',
            'position' => 'max:255',
            'birth_date' => 'date|before:yesterday',
        ]);

        $team = Team::find($request->team);

        $team->players()->create([
            'name' => $request->name,
            'position' => $request->position,
            'birth_date' => $request->birth_date,
            'team_id' => $team->id
        ]);

        return redirect()->route('admin');
    }
}
