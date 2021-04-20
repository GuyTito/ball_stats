@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">{{ __('Save match event') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('match') }}">
                            @csrf

                            {{-- @if($errors->any())
								@foreach ($errors->all() as $error)
									<div class="alert alert-danger" role="alert">
										<span>{{ $error }}</span>
									</div>
								@endforeach
							@endif --}}

							<div class="form-group row">
                                <label for="team" class="col-md-4 col-form-label text-md-right">{{ __('Season') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="season" id="season" autofocus>
										{{-- <option >Select Season</option> --}}
                                        @foreach ($seasons as $season)
                                            <option value="{{ $season->id }}">
                                                {{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }} -
                                                {{ Carbon\Carbon::parse($season->end_date)->toFormattedDateString() }}
                                            </option>
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
                                <label for="date_played"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Date Played') }}</label>

                                <div class="col-md-6">
                                    <input id="date_played" type="date"
                                        class="form-control @error('date_played') is-invalid @enderror" name="date_played"
                                        value="{{ old('date_played') }}" required>

                                    @error('date_played')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="team"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Home Team') }}</label>

                                <div class="col-md-6">
                                    <input type="text" name="team_A" id="team_A" required class="typeahead get_teams form-control" value="{{ old('team_A') }}" />

                                    @error('team_A')
                                        <span class="text-danger" role="alert">
                                            <small><strong>{{ $message }}</strong></small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="team_A_score"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Home Team Score') }}</label>

                                <div class="col-md-6">
                                    <input id="team_A_score" type="number" min="0" step="1" pattern="\d+" value="{{ old('team_A_score', 0) }}"
                                        class="form-control score" name="team_A_score">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="team"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Away Team') }}</label>

                                <div class="col-md-6">
                                    <input type="text" name="team_B" id="team_B" required class="typeahead get_teams form-control" value="{{ old('team_B') }}"/>

                                    @error('team_B')
                                        <span class="text-danger" role="alert">
                                            <small><strong>{{ $message }}</strong></small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="team_B_score"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Away Team Score') }}</label>

                                <div class="col-md-6">
                                    <input id="team_B_score" type="number" min="0" step="1" pattern="\d+" value="{{ old('team_B_score', 0) }}"
                                        class="form-control score" name="team_B_score">
                                </div>
                            </div>

                            <div class="form-group row" id="addScorerDiv">
                                <label class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6" >
                                    Goal Scorers: <button id="addScorerBtn" class="btn btn-sm btn-outline-primary mx-2">+</button>

									@error('scorers.*')
										<span class="text-danger" role="alert">
											<small><strong>{{ $message }}</strong></small>
										</span>
									@enderror
                                </div>
								
                            </div>

                            <div class="form-group row" id="addAssistorDiv">
                                <label class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6" >
                                    Assists: <button id="addAssistorBtn" class="btn btn-sm btn-outline-primary mx-2">+</button>

									@error('assistors.*')
										<span class="text-danger" role="alert">
											<small><strong>{{ $message }}</strong></small>
										</span>
									@enderror
								</div>
								
                            </div>

                            <div class="form-group row">
                                <label for="referee"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Referee') }}</label>

                                <div class="col-md-6">
                                    <input id="referee" type="text"
                                        class="form-control @error('referee') is-invalid @enderror" name="referee"
                                        value="{{ old('referee') }}">

									@error('referee')
                                        <span class="text-danger" role="alert">
                                            <small><strong>{{ $message }}</strong></small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="venue"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Venue') }}</label>

                                <div class="col-md-6">
                                    <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror"
                                        name="venue" value="{{ old('venue') }}" required>

									@error('venue')
                                        <span class="text-danger" role="alert">
                                            <small><strong>{{ $message }}</strong></small>
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

    <script type="text/javascript">

		function getTypeaheadData(element, path) {
			$(element).typeahead({
				source: function(query, process) {
					return $.get(path, { query: query }, function(data) {
						return process(data);
					});
				}
			});
		}
        
        function showScorerDiv() {
            let id = $("div[id|='scorerDiv']").length ? $("div[id|='scorerDiv']").first().data("id") : 0
            id++
            return `<div class="form-group row" id="scorerDiv-${id}" data-id=${id} >
				<label class="col-md-4 col-form-label text-md-right"></label>

				<div class="col-md-6">
					<input type="text" class="typeahead get_players" name="scorers[]" id="scorer_${id}" placeholder="Name" size="17">
					<label class="mx-2">Goals: </label><input type="number" min="1" step="1" value="1" name="goals[]" id="goals_${id}" style="width: 3rem">
					<button class="btn btn-sm btn-outline-primary mx-2" onclick="negScorer(); $('#scorerDiv-${id}').remove(); return false;">-</button>
				</div>
            </div>`
        }
        
		function showAssistorDiv() {
            let id = $("div[id|='assistorDiv']").length ? $("div[id|='assistorDiv']").first().data("id") : 0
            id++
            return `<div class="form-group row" id="assistorDiv-${id}" data-id=${id} >
				<label class="col-md-4 col-form-label text-md-right"></label>

				<div class="col-md-6">
					<input type="text" class="typeahead get_players" name="assistors[]" id="assistor_${id}" placeholder="Name" size="16">
					<label class="mx-2">Assists: </label><input type="number" min="1" step="1" value="1" name="assists[]" id="assists_${id}" style="width: 3rem">
					<button class="btn btn-sm btn-outline-primary mx-2" onclick="negAssist(); $('#assistorDiv-${id}').remove(); return false;">-</button>
				<div>
            </div>`
        }

        var scorerCounter = 0 // numbers the scorer fields
        function negScorer() {
            scorerCounter--;
        }

        var assistorCounter = 0 // numbers the assistor fields
        function negAssist() {
            assistorCounter--;
        }

		var score = parseInt($("#team_A_score").val()) + parseInt($("#team_B_score").val())
		$(".score").change(function() {
			score = parseInt($("#team_A_score").val()) + parseInt($("#team_B_score").val())
			console.log({score});
		})

		$('#addScorerBtn').click(function(e) {
			e.preventDefault();
			if (score > 0 && scorerCounter < score) {
				scorerCounter++
				console.log({scorerCounter});
				$(`#addScorerDiv`).after(showScorerDiv);
			} else {
				alert("Number of goal scorers should be less or equal to team score");
				return false;
			}

			var path = "{{ route('player.getPlayers') }}";
			getTypeaheadData('.get_players', path)
		});

		$('#addAssistorBtn').click(function(e) {
			e.preventDefault();
			if (score > 0 && assistorCounter < score) {
				assistorCounter++
				console.log({assistorCounter});
				$(`#addAssistorDiv`).after(showAssistorDiv);
			} else {
				alert("Number of assist providers should be less or equal to team score");
				return false;
			}

			var path = "{{ route('player.getPlayers') }}";
			getTypeaheadData('.get_players', path)
		});

		var path = "{{ route('team.getTeams') }}";
		getTypeaheadData('.get_teams', path)

		

    </script>

@endsection
