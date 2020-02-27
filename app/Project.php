<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function show()
    {
        return $this->hasOne('App\Show','id','show_id');
    }

    public function songs()
    {
        return $this->hasMany('App\ProjectSong');
    }

    public function getAirDateAttribute($date)
    {
        return date("m/d/Y", strtotime($date));
    }
}
