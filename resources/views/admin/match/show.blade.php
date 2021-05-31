@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>Match Id: {{ $match->id }}</span>

                        <div>
                            @can('update', $match)
                                <button class="btn btn-primary">
                                    <a class="text-white" href="{{route('match.edit', $match)}}">Edit</a>
                                </button>
                            @endcan

                            @can('delete', $match)
                                <form action="{{ route('match.destroy', $match)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <div>
                            League: <a class="text-secondary" href="{{ route('league', $match->user) }}">{{$match->user->name}}</a> <br>
                            Season: <span> 
                                {{ Carbon\Carbon::parse($match->season->start_date)->toFormattedDateString() }} -
                                {{ Carbon\Carbon::parse($match->season->end_date)->toFormattedDateString() }}
                            </span> <br>
                        </div>

                        <div>{{ Carbon\Carbon::parse($match->date_played)->toFormattedDateString() }}</div>
                    </div>

                    <div>
                        <h4>
                            <a href="{{ route('team.show', $match->home_team) }}">{{$match->home_team->name}}</a>
                             {{$match->home_team_score}} - {{$match->away_team_score}}
                             <a href="{{ route('team.show', $match->away_team) }}">{{$match->away_team->name}}</a>
                        </h4>
                        
                        @if (($match->home_team_score + $match->away_team_score) > 0)
                            <div>
                                Goals:
                                <ul style="list-style: none;">
                                    @forelse ($match_goals as $match_goal)
                                        @foreach ($match_goal as $name => $player)
                                            <li>
                                                <a class="text-secondary" href="{{ route('player.show', $player[0]) }}">{{$name}}</a>
                                                {{ ' (' . $player[1] . ')' }}
                                            </li>
                                        @endforeach
                                    @empty
                                        Goal scorers not recorded.
                                    @endforelse
                                </ul>
                            </div>

                            <div>
                                Assists:
                                <ul style="list-style: none;">
                                    @forelse ($match_assists as $match_assist)
                                        @foreach ($match_assist as $name => $player)
                                            <li>
                                                <a class="text-secondary" href="{{ route('player.show', $player[0]) }}">{{$name}}</a> 
                                                {{ ' (' . $player[1] . ')' }}
                                            </li>
                                        @endforeach
                                    @empty
                                        Assist providers not recorded.
                                    @endforelse
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div>
                        <span>Referee: {{$match->referee ?? 'No referee'}}</span> <br>
                        <span>Venue: {{$match->venue}}</span> <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
