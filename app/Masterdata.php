<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Masterdata extends Eloquent
{
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'masterdata';
    protected $dates = ['deleted_at'];
    

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function masterdataitems()
    {
        return $this->belongsToMany('App\Masterdata');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')->whereNull('deleted_at');
    }
}
