@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $league->name }}

                    <div>Seasons:
                        <span >
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
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <h3>matches</h3>
                        @foreach ($matches as $match)
                            <div class="mb-2">
                                <div>{{ Carbon\Carbon::parse($match->date_played)->toFormattedDateString() }}</div>
                                {{$match->home_team->name}} {{$match->home_team_score}} - 
                                {{$match->away_team_score}} {{$match->away_team->name}}
                            </div>
                        @endforeach

                    </div>


                    <div>assists</div>
                    <div>goals</div>
                    <div>standings</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
