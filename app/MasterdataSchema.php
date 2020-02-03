<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterdataSchema extends Eloquent
{
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'schema';
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany('App\Masterdata');
    }

    public function masterdata()
    {
        return $this->belongsToMany('App\Masterdata');
    }
}
