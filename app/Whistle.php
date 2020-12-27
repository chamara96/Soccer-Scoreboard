<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Whistle extends Model
{
    protected $fillable = ['whistle_name', 'soundclip','created_by'];
}
