@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>{{ $team->name }}</h3>
                        
                        @can('update', $team)
                            <a href="{{route('team.edit', $team)}}">Edit</a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <span>Manager: {{$team->coach}}</span> <br>
                        <span>Location: {{$team->location}}</span> <br>
                        League: <a href="{{ route('league', $team->user) }}">{{$team->user->name}}</a>
                    </div>

                    <div class="mt-3">
                        <h4>Players</h4>
                        @forelse ($players as $player)
                            <a href="{{ route('player.show', $player) }}">{{$player->name}}</a> - 
                            <span>{{$player->position}}</span>
                            <br>
                        @empty
                            <span>No players in this team.</span>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <h4>matches</h4>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection