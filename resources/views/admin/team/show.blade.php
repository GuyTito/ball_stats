@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3>{{ $team->name }}</h3>

              @if ($team->logo)
                <div style='height: 50px; width: 50px;'>
                  <img src="{{ asset('/storage/' . $team->logo) }}" style='max-height: 100%; max-width: 100%;' alt="logo"/>
                </div>
              @endif

              <div>
                @can('update', $team)
                  <button class="btn btn-primary">
                    <a class="text-white" href="{{ route('team.edit', $team) }}">Edit</a>
                  </button>
                @endcan

                @can('delete', $team)
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    Delete
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Confirm delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                          <form action="{{ route('team.destroy', $team) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endcan
              </div>
            </div>
          </div>

          <div class="card-body">
            <div>
              <span>Manager: {{ $team->coach }}</span> <br>
              <span>Location: {{ $team->location }}</span> <br>
              League: <a href="{{ route('league', $team->user) }}">{{ $team->user->name }}</a>
            </div>

            <div class="mt-3">
              <div class="table-responsive-sm">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th>Player</th>
                      <th>Position</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($players as $player)
                      <tr>
                        <td><a href="{{ route('player.show', $player) }}">{{ $player->name }}</a></td>
                        <td>{{ $player->position }}</td>
                      </tr>
                    @empty
                      <p>No players in this team.</p>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <div class="mt-3">
              <h4>matches</h4>
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
@endsection
