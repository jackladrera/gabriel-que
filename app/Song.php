<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    //
    public function artists()
    {
        return $this->hasMany('App\SongArtist');
    }

    public function publishers()
    {
        return $this->hasMany('App\SongPublisher');
    }
}
