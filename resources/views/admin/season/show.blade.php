@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>Season Id: {{ $season->id }}</span>
                        
                        <div>
                            @can('update', $season)
                                <button class="btn btn-primary">
                                    <a class="text-white" href="{{route('season.edit', $season)}}">Edit</a>
                                </button>
                            @endcan

                            @can('delete', $season)
                                <form action="{{ route('season.destroy', $season)}}" method="post">
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
