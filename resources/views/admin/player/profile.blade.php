@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $player->name }}
                </div>

                <div class="card-body">
                    <div>
                        <h3>Player Info</h3>
                        League: <a href="{{ route('league', $player->user) }}">{{$player->user->name}}</a><br>
                        Team: <a href="{{ route('team', $player->team) }}">{{$player->team->name}}</a> <br>
                        <span>Position: {{$player->position}}</span> <br>
                    </div>

                    <div>
                        <h3>Goals</h3>
                        Season - Goals
                        @forelse ($goals as $player)
                            @foreach ($player as $date => $goals)
                                <div>{{ $date . ' - ' . $goals }}</div>
                            @endforeach
                        @empty
                            <span>No goals.</span>
                        @endforelse
                    </div>

                    <div>
                        <h3>Assists</h3>
                        Season - Assists
                        @forelse ($assists as $player)
                            @foreach ($player as $date => $assists)
                                <div>{{ $date . ' - ' . $assists }}</div>
                            @endforeach
                        @empty
                            <span>No assists.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
