@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3>{{ $league->name }}</h3>
              {{-- <a href="{{route('league.edit')}}">Edit</a> --}}
            </div>

            <div>
              {{ $league->city }} - {{ $league->region }} - {{ $league->country }}
            </div>
          </div>

          <div class="card-body">
            <div class="dropdown mb-3">Season:
              <a class="text-secondary" href="{{ route('season.show', $current_season) }}">
                {{ Carbon\Carbon::parse($current_season->start_date)->toFormattedDateString() }} -
                {{ Carbon\Carbon::parse($current_season->end_date)->toFormattedDateString() }}
              </a>

              <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
              </button>

              @foreach ($seasons as $season)
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="{{ route('league', ['user' => $league, 'season' => $season]) }}">
                    {{ Carbon\Carbon::parse($season->start_date)->toFormattedDateString() }} -
                    {{ Carbon\Carbon::parse($season->end_date)->toFormattedDateString() }}
                  </a>
                </div>
              @endforeach
            </div>

            <div class="bs-example">
              <ul class="nav nav-tabs nav-fill" id="stats">
                <li class="nav-item">
                  <a href="#standings" class="nav-link" data-toggle="tab">Standings</a>
                </li>
                <li class="nav-item">
                  <a href="#goals" class="nav-link" data-toggle="tab">Goals</a>
                </li>
                <li class="nav-item">
                  <a href="#assists" class="nav-link" data-toggle="tab">Assists</a>
                </li>
                <li class="nav-item">
                  <a href="#matches" class="nav-link" data-toggle="tab">Matches</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade" id="standings">
                  <h4 class="mt-2">Standings</h4>
                  <div class="table-responsive-sm">
                    <table class="table table-hover table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Club</th>
                          <th>MP</th>
                          <th>W</th>
                          <th>D</th>
                          <th>L</th>
                          <th>Pts</th>
                          <th>GS</th>
                          <th>GC</th>
                          <th>GD</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($standings as $team)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('team.show', $team['team']) }}">{{ $team['team']->name }}</a></td>
                            <td>{{ $team['mp'] }}</td>
                            <td>{{ $team['w'] }}</td>
                            <td>{{ $team['d'] }}</td>
                            <td>{{ $team['l'] }}</td>
                            <td><strong>{{ $team['pts'] }}</strong></td>
                            <td>{{ $team['gs'] }}</td>
                            <td>{{ $team['gc'] }}</td>
                            <td>{{ $team['gs'] - $team['gc'] }}</td>
                          </tr>
                        @empty
                          <p>No team created.</p>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="goals">
                  <h4 class="mt-2">Goals</h4>
                  <div class="table-responsive-sm">
                    <table class="table table-hover table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Player</th>
                          <th>Club</th>
                          <th>Goals</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($goals as $player)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a
                                href="{{ route('player.show', $player['player']) }}">{{ $player['player']->name }}</a>
                            </td>
                            <td>{{ $player['team'] }}</td>
                            <td>{{ $player['goals'] }}</td>
                          </tr>
                        @empty
                          <p>No goals recorded.</p>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="assists">
                  <h4 class="mt-2">Assists</h4>
                  <div class="table-responsive-sm">
                    <table class="table table-hover table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Player</th>
                          <th>Club</th>
                          <th>Assists</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($assists as $player)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a
                                href="{{ route('player.show', $player['player']) }}">{{ $player['player']->name }}</a>
                            </td>
                            <td>{{ $player['team'] }}</td>
                            <td>{{ $player['assists'] }}</td>
                          </tr>
                        @empty
                          <p>No assists recorded.</p>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="matches">
                  <h4 class="mt-2">Matches</h4>
                  <div>
                    @forelse  ($matches as $match)
                      <div class="mb-2">
                        <a href="{{ route('match.show', $match) }}">
                          <div>{{ Carbon\Carbon::parse($match->date_played)->toFormattedDateString() }}</div>
                          {{ $match->home_team->name }} {{ $match->home_team_score }} -
                          {{ $match->away_team_score }} {{ $match->away_team->name }}
                        </a>
                      </div>
                    @empty
                      <p>No match event recorded.</p>
                    @endforelse
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $("#stats li:eq() a").tab('show'); // show 1st tab on page load
      });
    </script>
  </div>
@endsection
