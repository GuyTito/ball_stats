@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>{{ $player->name }}</h3>
                        @auth
                            <a href="{{route('player.edit', $player)}}">Edit</a>
                        @endauth
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        League: <a href="{{ route('league', $player->user) }}">{{$player->user->name}}</a><br>
                        Team: <a href="{{ route('team.show', $player->team) }}">{{$player->team->name}}</a> <br>
                        <span>Position: {{$player->position}}</span> <br>
                        <span>Date of Birth: {{  Carbon\Carbon::parse($player->birth_date)->toFormattedDateString() }}</span>
                    </div>

                    <div class="mt-3">
                        <h4>Goals</h4>
                        Season - Goals
                        @forelse ($goals as $player)
                            @foreach ($player as $date => $goals)
                                <div>{{ $date . ' - ' . $goals }}</div>
                            @endforeach
                        @empty
                            <span>No goals.</span>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <h4>Assists</h4>
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
