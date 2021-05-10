@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $league->name }}

                    <div>Seasons:
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
                        <h3>goals</h3>

                    </div>


                    <div>assists</div>
                    <div>matches</div>
                    <div>standings</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
