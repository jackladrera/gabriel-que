<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    //
    public function songs()
    {
        return $this->hasMany('App\SongPublisher');
    }
}
