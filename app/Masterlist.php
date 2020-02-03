<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Masterlist extends Eloquent
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'masterlist';
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function items()
    {
        return $this->hasMany('App\Masterlistitem');
    }
}
