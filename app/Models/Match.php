<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = [
        'season',
        'date_played',
        'team_A',
        'team_A_score',
        'team_B',
        'team_B_score',
        'referee',
        'venue'
    ];
}
