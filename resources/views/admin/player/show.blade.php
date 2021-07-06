@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3>{{ $player->name }}</h3>

              <div>
                @can('update', $player)
                  <button class="btn btn-primary">
                    <a class="text-white" href="{{ route('player.edit', $player) }}">Edit</a>
                  </button>
                @endcan

                <!-- Button trigger modal -->
                @can('delete', $player)
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

                          <form action="{{ route('player.destroy', $player) }}" method="post">
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
              League: <a href="{{ route('league', $player->user) }}">{{ $player->user->name }}</a><br>
              Team: <a href="{{ route('team.show', $player->team) }}">{{ $player->team->name }}</a> <br>
              <span>Position: {{ $player->position }}</span> <br>
              <span>Date of Birth:
                {{ Carbon\Carbon::parse($player->birth_date)->toFormattedDateString() }}</span>
            </div>

            <div class="mt-3">
              <h4>Goals</h4>
              <div class="table-responsive-sm">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th>Season</th>
                      <th>Goals</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($goals as $player)
                      @foreach ($player as $date => $goals)
                        <tr>
                          <td>{{ $date }}</td>
                          <td>{{ $goals }}</td>
                        </tr>
                      @endforeach
                    @empty
                      <p>No goals recorded.</p>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <div class="mt-3">
              <h4>Assists</h4>
              <div class="table-responsive-sm">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th>Season</th>
                      <th>Assists</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($assists as $player)
                      @foreach ($player as $date => $assists)
                        <tr>
                          <td>{{ $date }}</td>
                          <td>{{ $assists }}</td>
                        </tr>
                      @endforeach
                    @empty
                      <p>No assists recorded.</p>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
