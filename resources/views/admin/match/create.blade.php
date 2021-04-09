@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Save match event') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('match') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="team" class="col-md-4 col-form-label text-md-right">{{ __('Season') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="season" id="season" autofocus>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id }}">{{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($season->end_date)->toFormattedDateString() }}</option>
                                    @endforeach
                                </select>

                                @error('season')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth_day" class="col-md-4 col-form-label text-md-right">{{ __('Date Played') }}</label>

                            <div class="col-md-6">
                                <input id="date_played" type="date" class="form-control @error('date_played') is-invalid @enderror" name="date_played" value="{{ old('date_played') }}" required>

                                @error('date_played')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team" class="col-md-4 col-form-label text-md-right">{{ __('Home Team') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="team_A" id="team_A">
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>

                                @error('team_A')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team_A_score" class="col-md-4 col-form-label text-md-right">{{ __('Home Team Score') }}</label>

                            <div class="col-md-6">
                                <input id="team_A_score" type="number" min="0" step="1" pattern="\d+" class="form-control @error('team_A_score') is-invalid @enderror" name="team_A_score" value="{{ old('team_A_score') }}">

                                @error('team_A_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team" class="col-md-4 col-form-label text-md-right">{{ __('Away Team') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="team_B" id="team_B">
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>

                                @error('team_B')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team_B_score" class="col-md-4 col-form-label text-md-right">{{ __('Away Team Score') }}</label>

                            <div class="col-md-6">
                                <input id="team_B_score" type="number" min="0" step="1" pattern="\d+" class="form-control @error('team_B_score') is-invalid @enderror" name="team_B_score" value="{{ old('team_B_score') }}">

                                @error('team_B_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="referee" class="col-md-4 col-form-label text-md-right">{{ __('Referee') }}</label>

                            <div class="col-md-6">
                                <input id="referee" type="text" class="form-control @error('referee') is-invalid @enderror" name="referee" value="{{ old('referee') }}">

                                @error('referee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="venue" class="col-md-4 col-form-label text-md-right">{{ __('Venue') }}</label>

                            <div class="col-md-6">
                                <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" value="{{ old('venue') }}" required>

                                @error('venue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
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
