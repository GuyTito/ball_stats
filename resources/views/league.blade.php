@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>{{ $league->name }}</h3>
                        {{-- <a href="{{route('league.edit')}}">Edit</a> --}}
                    </div>
                    
                    <div>
                        {{$league->city}} - {{$league->region}} - {{$league->country}}
                    </div>
                </div>

                <div class="card-body">
                    

                    <div>Seasons:
                        <a class="text-secondary" href="{{ route('season.show', $current_season) }}">
                            {{ Carbon\Carbon::parse($current_season->start_date)->toFormattedDateString() }} -
                            {{ Carbon\Carbon::parse($current_season->end_date)->toFormattedDateString() }}
                        </a>
                        @foreach ($seasons as $season)
                            <div> 
                                <a href="{{ route('league', ['user' => $league, 'season' => $season]) }}">
                                    {{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }} -
                                    {{ Carbon\Carbon::parse($season->end_date)->toFormattedDateString() }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                

                
                    <div class="mt-3">
                        <h3>standings</h3>
                        <strong>team</strong> - <strong>MP</strong> - <strong>W</strong> - <strong>D</strong> - <strong>L</strong> - <strong>GS/GC</strong> - <strong>Pts</strong>
                        
                        @forelse ($standings as $team)
                            <div>
                                <a href="{{ route('team.show', $team['team']) }}">{{$team['team']->name}}</a> - 
                                {{$team['mp']}} - 
                                {{$team['w']}} - 
                                {{$team['d']}} - 
                                {{$team['l']}} - 
                                {{$team['gs']}}/{{$team['gc']}} - 
                                <strong>{{$team['pts']}}</strong>
                            </div>
                        @empty
                            <p>No team created.</p> 
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <h3>matches</h3>
                        @forelse  ($matches as $match)
                            <div class="mb-2">
                                <a href="{{ route('match.show', $match) }}">
                                    <div>{{ Carbon\Carbon::parse($match->date_played)->toFormattedDateString() }}</div>
                                    {{$match->home_team->name}} {{$match->home_team_score}} - 
                                    {{$match->away_team_score}} {{$match->away_team->name}}
                                </a>
                            </div>
                        @empty
                           <p>No match event recorded.</p> 
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <h3>goals</h3>
                        @forelse ($goals as $player)
                            <div>
                                <a href="{{ route('player.show', $player['player']) }}">{{$player['player']->name}}</a> - 
                                {{$player['team']}} - 
                                {{$player['goals']}}
                            </div>
                        @empty
                            <p>No goals recorded.</p>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <h3>assists</h3>
                        @forelse ($assists as $player)
                            <div>
                                <a href="{{ route('player.show', $player['player']) }}">{{$player['player']->name}}</a> - 
                                {{$player['team']}} - 
                                {{$player['assists']}}
                            </div>
                        @empty
                            <p>No assists recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
