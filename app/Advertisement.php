<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = ['ad_title', 'game_id', 'created_by', 'path'];
}
