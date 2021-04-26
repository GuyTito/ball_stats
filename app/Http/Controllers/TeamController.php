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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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

        // dd([$request->name, $request->coach, $request->location, $request->user()->id]);

        request()->user()->teams()->create($this->validateTeam());

        return redirect()->route('admin');
    }

    public function getTeams(){
        $data = Team::select('name')->get();;
   
        return response()->json($data);
    }
}
