@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Match Id: {{ $match->id }}
                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <div>
                            League: <a href="{{ route('league', $match->user) }}">{{$match->user->name}}</a> <br>
                            Season: <span> 
                                {{ Carbon\Carbon::parse($match->season->start_date)->toFormattedDateString() }} -
                                {{ Carbon\Carbon::parse($match->season->end_date)->toFormattedDateString() }}
                            </span> <br>
                        </div>

                        <div>{{ Carbon\Carbon::parse($match->date_played)->toFormattedDateString() }}</div>
                    </div>

                    <div>
                        <h4>
                            {{$match->home_team->name}} {{$match->home_team_score}} - 
                            {{$match->away_team_score}} {{$match->away_team->name}}
                        </h4>
                        <div>
                            Goals:
                            <div>
                                {{-- @foreach ($collection as $item)
                                    
                                @endforeach --}}
                            </div>
                        </div>
                        <div>
                            Assists:
                            <div></div>
                        </div>

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
