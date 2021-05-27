@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>Season Id: {{ $season->id }}</span>
                        
                        @can('update', $season)
                            <a href="{{route('season.edit', $season)}}">Edit</a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        {{ __('Start Date') }}: {{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }}</div>
                    <div>
                        {{ __('End Date') }}: {{ Carbon\Carbon::parse($season->end_date)->toFormattedDateString() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
