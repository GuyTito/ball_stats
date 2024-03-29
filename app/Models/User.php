<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'slug',
    'email',
    'password',
    'city',
    'region',
    'country',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];


  public function seasons()
  {
    return $this->hasMany(Season::class);
  }

  public function teams()
  {
    return $this->hasMany(Team::class);
  }

  public function players()
  {
    return $this->hasMany(Player::class);
  }

  public function match_events()
  {
    return $this->hasMany(MatchEvent::class);
  }

  public function goals()
  {
    return $this->hasMany(Goals::class);
  }

  public function assists()
  {
    return $this->hasMany(Assists::class);
  }
}
