<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['game_name', 'date', 'ground', 'game_logo', 'team_a', 'team_b', 'created_by'];
}
