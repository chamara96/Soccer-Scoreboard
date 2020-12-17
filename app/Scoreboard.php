<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
    protected $fillable = ['game_id', 'score_team_a', 'score_team_b', 'time', 'status', 'timer_id', 'created_by'];
}
