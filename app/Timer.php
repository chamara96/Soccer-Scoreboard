<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    protected $fillable = ['timer_name', 'time', 'start_whistle_id', 'end_whistle_id', 'created_by'];
}
