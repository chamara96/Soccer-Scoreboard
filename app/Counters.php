<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Counters extends Model
{
    protected $fillable = ['game_id', 'status', 'timer_id','created_by','remaining_time'];

    // protected $attributes = [
    //     'created_by' => Auth::id()
    // ];
}
