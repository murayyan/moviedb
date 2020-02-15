<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{

    protected $hidden = ['created_at', 'updated_at', 'pivot'];
    public function movie()
    {
        return $this->belongsToMany('App\Movie');
    }
}
