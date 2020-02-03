<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomTableItems extends Eloquent
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'customTableItems';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function form()
    {
        return $this->hasOne('App\Form')->whereNull('deleted_at');
    }

    public function customtable()
    {
        return $this->belongsToMany('App\Masterlist');
    }
}
