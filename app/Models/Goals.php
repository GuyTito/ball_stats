<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'season_id',
        'match_id',
        'goals'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function match_event()
    {
        return $this->belongsTo(MatchEvent::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
