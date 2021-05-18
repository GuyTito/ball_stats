@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Sorry, something ain't right.
                </div>

                <div class="card-body">
                    <span class="text-danger" role="alert">
                        <small><strong>{{ $message }}</strong></small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
