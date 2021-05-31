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
        $this->middleware(['auth'])->only(['create','store','edit','update','destroy']);
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
        $this->authorize('update', $season);
        return view('admin.season.edit', ['season' => $season]);
    }

    public function update(Season $season)
    {
        $this->authorize('update', $season);
        $season->update($this->validateSeason());
        return redirect()->route('season.show', $season);
    }

    public function destroy(Season $season)
    {
        $this->authorize('delete', $season);
        $season->destroy($season->id);
        return redirect()->route('league', $season->user);
    }
}
