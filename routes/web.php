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

Route::get('/admin/match/create', [MatchEventController::class, 'create'])->name('match.create');
Route::post('/admin/match', [MatchEventController::class, 'store'])->name('match.store');
Route::get('/admin/match/{match}', [MatchEventController::class, 'show'])->name('match.show');
Route::get('/admin/match/{match}/edit', [MatchEventController::class, 'edit'])->name('match.edit');
Route::put('/admin/match/{match}', [MatchEventController::class, 'update'])->name('match.update');
Route::delete('/admin/match/{match}', [MatchEventController::class, 'destroy'])->name('match.destroy');

Route::get('/admin/team/getplayers', [PlayerController::class, 'index'])->name('players');
Route::get('/admin/player/create', [PlayerController::class, 'create'])->name('player.create');
Route::post('/admin/player', [PlayerController::class, 'store'])->name('player.store');
Route::get('/admin/player/{player:name}', [PlayerController::class, 'show'])->name('player.show');
Route::get('/admin/player/{player:name}/edit', [PlayerController::class, 'edit'])->name('player.edit');
Route::put('/admin/player/{player:name}', [PlayerController::class, 'update'])->name('player.update');
Route::delete('/admin/player/{player}', [PlayerController::class, 'destroy'])->name('player.destroy');

Route::get('/admin/team/getteams', [TeamController::class, 'index'])->name('teams');
Route::get('/admin/team/create', [TeamController::class, 'create'])->name('team.create');
Route::post('/admin/team', [TeamController::class, 'store'])->name('team.store');
Route::get('/admin/team/{team:name}', [TeamController::class, 'show'])->name('team.show');
Route::get('/admin/team/{team:name}/edit', [TeamController::class, 'edit'])->name('team.edit');
Route::put('/admin/team/{team:name}', [TeamController::class, 'update'])->name('team.update');
Route::delete('/admin/team/{team:name}', [TeamController::class, 'destroy'])->name('team.destroy');

Route::get('/admin/season/create', [SeasonController::class, 'create'])->name('season.create');
Route::post('/admin/season', [SeasonController::class, 'store'])->name('season.store');
Route::get('/admin/season/{season}', [SeasonController::class, 'show'])->name('season.show');
Route::get('/admin/season/{season}/edit', [SeasonController::class, 'edit'])->name('season.edit');
Route::put('/admin/season/{season}', [SeasonController::class, 'update'])->name('season.update');
Route::delete('/admin/season/{season}', [SeasonController::class, 'destroy'])->name('season.destroy');

