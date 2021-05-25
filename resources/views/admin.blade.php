@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Page') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-2">
                        <a href="{{ route('match.create') }}">
                            {{ __('Save match event') }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('player.create') }}">
                            {{ __('Add football player') }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('team.create') }}">
                            {{ __('Create football team') }}
                        </a>
                    </div>
                    <div>
                        <a class="" href="{{ route('season.create') }}">
                            {{ __('Create football season') }}
                        </a>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
