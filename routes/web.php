<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MatchEventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function(){
//     return view('home');
// })->name('home');
Route::get('/', [LeagueController::class, 'index'])->name('home');

Route::get('/league/{user:name}', [LeagueController::class, 'show'])->name('league');

Auth::routes();

Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/admin/match/create', [MatchEventController::class, 'index'])->name('match.create');
Route::post('/admin/match', [MatchEventController::class, 'store'])->name('match.store');
Route::get('/admin/match/{match}', [MatchEventController::class, 'match_event'])->name('match');

Route::get('/admin/player/create', [PlayerController::class, 'index'])->name('player.create');
Route::get('/admin/team/getplayers', [PlayerController::class, 'getPlayers'])->name('player.getPlayers');
Route::post('/admin/player', [PlayerController::class, 'store'])->name('player.store');
Route::get('/admin/player/{player:name}', [PlayerController::class, 'player'])->name('player');

Route::get('/admin/team/create', [TeamController::class, 'index'])->name('team.create');
Route::get('/admin/team/getteams', [TeamController::class, 'getTeams'])->name('team.getTeams');
Route::post('/admin/team', [TeamController::class, 'store'])->name('team.store');
Route::get('/admin/team/{team:name}', [TeamController::class, 'team'])->name('team');

Route::get('/admin/season/create', [SeasonController::class, 'index'])->name('season.create');
Route::post('/admin/season', [SeasonController::class, 'store'])->name('season');
