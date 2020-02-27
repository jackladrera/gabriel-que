<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongArtist extends Model
{
    //
    public function artist()
    {
        return $this->belongsTo('App\Artist');
    }

    public function song()
    {
        return $this->belongsTo('App\Song');
    }
}
