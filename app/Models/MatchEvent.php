<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'date_played',
        'home_team_id',
        'home_team_score',
        'away_team_id',
        'away_team_score',
        'win_team_id',
        'loss_team_id',
        'referee',
        'venue'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function goals()
    {
        return $this->hasMany(Goals::class);
    }

    public function assists()
    {
        return $this->hasMany(Assists::class);
    }

    public function home_team()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }
    
    public function away_team()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
