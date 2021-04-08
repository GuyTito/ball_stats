<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeasonController extends Controller
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
        return view('admin.season.create');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'required|date|after:tomorrow'
        ]);

        dd([$request->start_date, $request->end_date, $request->user()->id]);

        // $request->user()->seasons()->create([
        //     'start_date' => $request->start_date,
        //     'end_date' => $request->end_date,
        //     'user_id' => $request->user()->id
        // ]);

        // return back(); 
    }
}
