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
        'referee',
        'venue'
    ];
}
