@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $team->name }}

                    {{-- <div>Seasons:
                        <span>
                            {{ Carbon\Carbon::parse($current_season->start_date)->toFormattedDateString() }} -
                            {{ Carbon\Carbon::parse($current_season->end_date)->toFormattedDateString() }}
                        </span>
                        @foreach ($seasons as $season)
                            <div> 
                                <a href="{{ route('league', ['user' => $league, 'season' => $season]) }}">
                                    {{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }} -
                                    {{ Carbon\Carbon::parse($season->end_date)->toFormattedDateString() }}
                                </a>
                            </div>
                        @endforeach
                    </div> --}}
                </div>

                <div class="card-body">
                    <div>
                        <h3>Team Info</h3>
                        <span>Manager: {{$team->coach}}</span> <br>
                        <span>Location: {{$team->location}}</span> <br>
                        <span>League: {{$team->user->name}}</span>
                    </div>

                    <div>
                        <h3>Players</h3>
                        @forelse ($players as $player)
                            <a href="{{ route('player', $player) }}">{{$player->name}}</a> - 
                            <span>{{$player->position}}</span>
                            <br>
                        @empty
                            <span>No players in this team.</span>
                        @endforelse
                    </div>

                    <div>
                        <h3>matches</h3>
                        @forelse  ($matches as $match)
                            <div class="mb-2">
                                <a href="{{ route('match', $match) }}">
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
