<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth'])->only(['create', 'store', 'edit', 'update', 'destroy']);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $data = Team::select('name')->get();
    return response()->json($data);
  }

  public function create()
  {
    return view('admin.team.create');
  }

  private function validateTeam($team = null)
  {
    return request()->validate([
      'name' => ['required', 'max:255', Rule::unique('teams')->ignore($team)],
      'coach' => ['required', 'max:255', Rule::unique('teams')->ignore($team)],
      'logo' => 'image|max:1000',
      'location' => 'required|max:255'
    ]);
  }

  private function checkLogo($team = null)
  {
    if (request('logo')) {
      $logo_path = request('logo')->store('team_logos');
      return array_replace($this->validateTeam($team), ["logo" => $logo_path]);
    } else {
      return $this->validateTeam($team);
    }
  }

  public function store()
  {
    $team_data = $this->checkLogo();

    $slug = Str::slug(request('name'));
    $team_data = array_merge($team_data, ["slug" => $slug]);

    $team_stored = request()->user()->teams()->create($team_data);
    return redirect()->route('team.show', $team_stored);
  }

  private function getMatches($team)
  {
    $home_matches = $team->home_matches()->get();
    $away_matches = $team->away_matches()->get();
    $matches = $home_matches->merge($away_matches);
    $matches = $matches->sort(function ($a, $b) {
      if ($a->date_played === $b->date_played) {
        if ($a->created_at === $b->created_at) return 0;
        return $a->created_at < $b->created_at ? -1 : 1;
      }
      return $a->date_played < $b->date_played ? -1 : 1;
    });

    return $matches;
  }

  public function show(Team $team)
  {
    $players = $team->players()->get();

    $matches = $this->getMatches($team);

    return view('admin.team.show', [
      'team' => $team,
      'players' => $players,
      'matches' => $matches->reverse(),
    ]);
  }

  public function edit(Team $team)
  {
    $this->authorize('update', $team);
    return view('admin.team.edit', ['team' => $team]);
  }


  public function update(Team $team)
  {
    $this->authorize('update', $team);

    $team_data = $this->checkLogo($team);

    $slug = Str::slug(request('name'));
    $team_data = array_merge($team_data, ["slug" => $slug]);

    $team->update($team_data);
    return redirect()->route('team.show', $team);
  }

  public function destroy(Team $team)
  {
    $this->authorize('delete', $team);
    $team->destroy($team->id);
    return redirect()->route('league', $team->user);
  }
}
