<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Eloquent
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'groups';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'name', 
        'description' 
    ];


    public function users()
    {
        return $this->belongsToMany('App\User')->whereNull('deleted_at');
    }
    
    public function forms()
    {
        return $this->belongsToMany('App\Form');
    }

    public function masterdata()
    {
        return $this->belongsToMany('App\Masterdata')->whereNull('deleted_at');
    }
    
}
