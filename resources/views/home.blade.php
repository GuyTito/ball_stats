@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Leagues') }}</div>

                <div class="card-body">
                    @forelse ($leagues as $league)
                        <div>
                            <a href="{{ route('league', $league) }}"> {{ $league->name }} </a>
                        </div>
                    @empty
                        <p>No leagues. Create a league.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
