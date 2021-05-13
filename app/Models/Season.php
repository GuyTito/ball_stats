<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
