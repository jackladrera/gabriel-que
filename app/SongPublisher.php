<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongPublisher extends Model
{
    //
    public function publisher()
    {
        return $this->belongsTo('App\Publisher');
    }

    public function song()
    {
        return $this->belongsTo('App\Song');
    }
}
