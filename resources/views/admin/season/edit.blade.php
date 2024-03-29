@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Edit Season Dates') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('season.update', $season) }}">
              @csrf
              @method('PUT')

              <div class="form-group row">
                <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>

                <div class="col-md-6">
                  {{-- <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror"
                    name="start_date"
                    value="{{ old('date_played', Carbon\Carbon::parse($season->start_date)->toDateString()) }}" required
                    autofocus> --}}
                  <span class="form-control">{{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }}</span>

                  @error('start_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>

                <div class="col-md-6">
                  <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror"
                    name="end_date"
                    value="{{ old('end_date', Carbon\Carbon::parse($season->end_date)->toDateString()) }}" required>

                  @error('end_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Update
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
