<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Eloquent
{
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'items';
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function masterlist()
    {
        return $this->belongsToMany('App\Masterlist');
    }
}