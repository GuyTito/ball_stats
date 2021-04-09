<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SeasonController;
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

Route::get('/', function(){
    return view('home');
})->name('home');

Auth::routes();

Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/admin/match/create', [MatchController::class, 'index'])->name('match.create');
Route::post('/admin/match', [MatchController::class, 'store'])->name('match');

Route::get('/admin/player/create', [PlayerController::class, 'index'])->name('player.create');
Route::post('/admin/player', [PlayerController::class, 'store'])->name('player');

Route::get('/admin/team/create', [TeamController::class, 'index'])->name('team.create');
Route::post('/admin/team', [TeamController::class, 'store'])->name('team');

Route::get('/admin/season/create', [SeasonController::class, 'index'])->name('season.create');
Route::post('/admin/season', [SeasonController::class, 'store'])->name('season');
