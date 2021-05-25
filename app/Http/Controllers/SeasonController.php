<?php

namespace App\Http\Controllers;

use App\Models\Season;

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
    public function create()
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
        request()->user()->seasons()->create($this->validateSeason());

        return redirect()->route('admin');
    }

    public function show(Season $season)
    {
        return view('admin.season.show', [
            'season' => $season,
        ]);
    }

    public function edit(Season $season)
    {
        return view('admin.season.edit', ['season' => $season]);
    }

    public function update(Season $season)
    {
        dd($season);
    }
}
