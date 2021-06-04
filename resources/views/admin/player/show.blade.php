@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>{{ $player->name }}</h3>
                        
                        <div>
                            @can('update', $player)
                                <button class="btn btn-primary">
                                    <a class="text-white" href="{{route('player.edit', $player)}}">Edit</a>
                                </button>
                            @endcan

                            @can('delete', $player)
                                <form action="{{ route('player.destroy', $player)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
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
                        <div class="table-responsive-sm">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Season</th>
                                        <th>Goals</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($goals as $player)
                                        @foreach ($player as $date => $goals)
                                            <tr>
                                                <td>{{$date}}</td>
                                                <td>{{$goals}}</td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <p>No goals recorded.</p>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h4>Assists</h4>
                        <div class="table-responsive-sm">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Season</th>
                                        <th>Assists</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($assists as $player)
                                        @foreach ($player as $date => $assists)
                                            <tr>
                                                <td>{{$date}}</td>
                                                <td>{{$assists}}</td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <p>No assists recorded.</p>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
