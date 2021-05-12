<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'coach'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function match_events()
    {
        return $this->hasMany(MatchEvent::class, 'home_team_id', 'away_team_id');
    }

    public function home_matches()
    {
        return $this->hasMany(MatchEvent::class, 'home_team_id');
    }

    public function away_matches()
    {
        return $this->hasMany(MatchEvent::class, 'away_team_id');
    }


}
