<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'coach' => 'required|max:255',
            'location' => 'required|max:255'
        ]);

        // dd([$request->name, $request->coach, $request->location, $request->user()->id]);

        $request->user()->teams()->create([
            'name' => $request->name,
            'coach' => $request->coach,
            'location' => $request->location,
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('admin');
    }

    public function getTeams(){
        // $data = Team::select("name")
        //     ->where("name","LIKE","%{$request->input('query')}%")
        //     ->get();

        $data = Team::select('name')->get();;
   
        return response()->json($data);
    }
}
