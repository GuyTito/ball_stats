<?php

namespace App\Http\Controllers;


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

    private function validateSeason()
    {
        return request()->validate([
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'required|date|after:tomorrow'
        ]);
    }
    
    public function store()
    {
        //dd([request()->start_date, request()->end_date, request()->user()->id]);

        request()->user()->seasons()->create($this->validateSeason());

        return redirect()->route('admin');
    }
}
