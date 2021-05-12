<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = User::all();
        return view('home', ['leagues' => $leagues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if( request()->has('season') && $user->seasons()->find(request()->query('season')) ) {
            $season_id = request()->query('season');
        } else {
            $season_id = $user->seasons()->latest()->first()->id;
        }
        
        $seasons  = $user->seasons()->latest()->get();
        $current_season = $user->seasons()->find($season_id);
        
        $matches =  $user->match_events()->latest()->where('season_id', $season_id)->get();
        // $goals =  $user->goals()->where('season_id', $season_id)->get();
        // $assists =  $user->assists()->where('season_id', $season_id)->get();
        // dd($matches);
        
        return view('league', [
            'league' => $user,
            'seasons' => $seasons,
            'current_season' => $current_season,
            'matches' => $matches
        ]);
    }

    
    public function assists()
    {
        return view('assists');
    }

    
    public function matches()
    {
        return view('matches');    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
