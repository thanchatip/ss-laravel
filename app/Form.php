<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class Form extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'form';

    public function users()
    {
        return $this->belongsToMany('App\User')->whereNull('deleted_at');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')->whereNull('deleted_at');
    }
}
