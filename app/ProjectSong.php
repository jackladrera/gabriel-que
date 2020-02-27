<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectSong extends Model
{
    //
    public function song()
    {
        return $this->belongsTo('App\Song');
    }
}
