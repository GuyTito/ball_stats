@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header text-center">{{ __('Save match event') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('match.update', $match) }}">
              @csrf
              @method('PUT')

              {{-- @if ($errors->any())
								@foreach ($errors->all() as $error)
									<div class="alert alert-danger" role="alert">
										<span>{{ $error }}</span>
									</div>
								@endforeach
							@endif --}}

              {{-- @error('notInserted')
                                <div class="alert alert-danger" role="alert">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror --}}

              <div class="form-group row">
                <label for="team" class="col-md-4 col-form-label text-md-right">{{ __('Season') }}</label>

                <div class="col-md-6">
                  <select class="form-control" name="season_id" id="season_id" autofocus>
                    <option value="{{ $match->season->id }}">
                      {{ Carbon\Carbon::parse($match->season->start_date)->toFormattedDateString() }} -
                      {{ Carbon\Carbon::parse($match->season->end_date)->toFormattedDateString() }}
                    </option>
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
                <label for="date_played" class="col-md-4 col-form-label text-md-right">{{ __('Date Played') }}</label>

                <div class="col-md-6">
                  <input id="date_played" type="date" class="form-control @error('date_played') is-invalid @enderror"
                    name="date_played"
                    value="{{ old('date_played', Carbon\Carbon::parse($match->date_played)->toDateString()) }}"
                    required>

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
                  <select class="form-control" name="home_team_id" id="home_team_id">
                    <option value="{{ $match->home_team->id }}">{{ $match->home_team->name }}</option>
                    @foreach ($teams as $team)
                      <option value="{{ $team->id }}" @if (old('home_team_id') == $team->id) {{ 'selected' }} @endif>{{ $team->name }}</option>
                    @endforeach
                  </select>

                  @error('home_team_id')
                    <span class="text-danger" role="alert">
                      <small><strong>{{ $message }}</strong></small>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="home_team_score"
                  class="col-md-4 col-form-label text-md-right">{{ __('Home Team Score') }}</label>

                <div class="col-md-6">
                  <input id="home_team_score" type="number" min="0" step="1" pattern="\d+"
                    value="{{ old('home_team_score', $match->home_team_score) }}" class="form-control score"
                    name="home_team_score">
                </div>
              </div>

              <div class="form-group row">
                <label for="team" class="col-md-4 col-form-label text-md-right">{{ __('Away Team') }}</label>

                <div class="col-md-6">
                  <select class="form-control" name="away_team_id" id="away_team_id">
                    <option value="{{ $match->away_team->id }}">{{ $match->away_team->name }}</option>
                    @foreach ($teams as $team)
                      <option value="{{ $team->id }}" @if (old('away_team_id') == $team->id) {{ 'selected' }} @endif>{{ $team->name }}</option>
                    @endforeach
                  </select>

                  @error('away_team_id')
                    <span class="text-danger" role="alert">
                      <small><strong>{{ $message }}</strong></small>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="away_team_score"
                  class="col-md-4 col-form-label text-md-right">{{ __('Away Team Score') }}</label>

                <div class="col-md-6">
                  <input id="away_team_score" type="number" min="0" step="1" pattern="\d+"
                    value="{{ old('away_team_score', $match->away_team_score) }}" class="form-control score"
                    name="away_team_score">
                </div>
              </div>

              <div class="form-group row" id="addScorerDiv">
                <label class="col-md-4 col-form-label text-md-right"></label>
                <div class="col-md-6">
                  Goal Scorers: <button id="addScorerBtn" class="btn btn-sm btn-outline-primary mx-2">+</button>

                  @error('scorers.*')
                    <span class="text-danger" role="alert">
                      <small><strong>{{ $message }}</strong></small>
                    </span>
                  @enderror
                </div>
              </div>
              @php($id = $match_goals->count() + 1)
              @forelse ($match_goals as $match_goal)
                @php($id--)
                @foreach ($match_goal as $name => $player)
                  <div class="form-group row" id="scorerDiv-{{ $id }}" data-id={{ $id }}>
                    <label class="col-md-4 col-form-label text-md-right"></label>

                    <div class="col-md-6">
                      <input type="text" class="typeahead get_players" name="scorers[]" id="scorer_{{ $id }}"
                        value="{{ $name }}" size="17">
                      <label class="mx-2">Goals: </label><input type="number" min="1" step="1"
                        value="{{ $player[1] }}" name="goals[]" id="goals_{{ $id }}" style="width: 3rem">
                      <button class="btn btn-sm btn-outline-primary mx-2"
                        onclick="negScorer(); $('#scorerDiv-{{ $id }}').remove(); return false;">-</button>
                    </div>
                  </div>
                @endforeach
              @empty
              @endforelse

              <div class="form-group row" id="addAssistorDiv">
                <label class="col-md-4 col-form-label text-md-right"></label>
                <div class="col-md-6">
                  Assists: <button id="addAssistorBtn" class="btn btn-sm btn-outline-primary mx-2">+</button>

                  @error('assistors.*')
                    <span class="text-danger" role="alert">
                      <small><strong>{{ $message }}</strong></small>
                    </span>
                  @enderror
                </div>

              </div>
              @php($id = $match_assists->count() + 1)
              @forelse ($match_assists as $match_assist)
                @php($id--)
                @foreach ($match_assist as $name => $player)
                  <div class="form-group row" id="assistorDiv-{{ $id }}" data-id={{ $id }}>
                    <label class="col-md-4 col-form-label text-md-right"></label>

                    <div class="col-md-6">
                      <input type="text" class="typeahead get_players" name="assistors[]"
                        id="assistor_{{ $id }}" value="{{ $name }}" size="16">
                      <label class="mx-2">Assists: </label><input type="number" min="1" step="1"
                        value="{{ $player[1] }}" name="assists[]" id="assists_{{ $id }}"
                        style="width: 3rem">
                      <button class="btn btn-sm btn-outline-primary mx-2"
                        onclick="negAssist(); $('#assistorDiv-{{ $id }}').remove(); return false;">-</button>
                    </div>
                  </div>
                @endforeach
              @empty
              @endforelse

              <div class="form-group row">
                <label for="referee" class="col-md-4 col-form-label text-md-right">{{ __('Referee') }}</label>

                <div class="col-md-6">
                  <input id="referee" type="text" class="form-control @error('referee') is-invalid @enderror"
                    name="referee" value="{{ old('referee', $match->referee) }}">

                  @error('referee')
                    <span class="text-danger" role="alert">
                      <small><strong>{{ $message }}</strong></small>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="venue" class="col-md-4 col-form-label text-md-right">{{ __('Venue') }}</label>

                <div class="col-md-6">
                  <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror" name="venue"
                    value="{{ old('venue', $match->venue) }}" required>

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

  <script src="/js/typeahead.js"></script>

  <script type="text/javascript">
    function getTypeaheadData(element, path) {
      $(element).typeahead({
        source: function(query, process) {
          return $.get(path, {
            query: query
          }, function(data) {
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

    var scorerCounter = $("div[id|='scorerDiv']").length ? $("div[id|='scorerDiv']").first().data("id") : 0 // numbers the scorer fields
    console.log({scorerCounter});

    function negScorer() {
      scorerCounter--;
    }

    var assistorCounter = $("div[id|='assistorDiv']").length ? $("div[id|='assistorDiv']").first().data("id") : 0 // numbers the assistor fields
    function negAssist() {
      assistorCounter--;
    }

    var score = parseInt($("#home_team_score").val()) + parseInt($("#away_team_score").val())

    $(".score").change(function() {
      score = parseInt($("#home_team_score").val()) + parseInt($("#away_team_score").val())
      console.log({score});
    })

    $('#addScorerBtn').click(function(e) {
      e.preventDefault();
      if (score > 0 && scorerCounter < score) {
        scorerCounter++
        console.log({scorerCounter});
        $(`#addScorerDiv`).after(showScorerDiv);
      } else {
        alert("Number of goal scored should be less or equal to total goals in this match");
        return false;
      }

      var path = "{{ route('players') }}";
      getTypeaheadData('.get_players', path)
    });

    $('#addAssistorBtn').click(function(e) {
      e.preventDefault();
      if (score > 0 && assistorCounter < score) {
        assistorCounter++
        console.log({
          assistorCounter
        });
        $(`#addAssistorDiv`).after(showAssistorDiv);
      } else {
        alert("Number of assists provided should be less or equal to total goals in this match");
        return false;
      }

      var path = "{{ route('players') }}";
      getTypeaheadData('.get_players', path)
    });

    var path = "{{ route('teams') }}";
    getTypeaheadData('.get_teams', path)

    var path = "{{ route('players') }}";
    getTypeaheadData('.get_players', path)
  </script>

@endsection
