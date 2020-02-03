<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Masterlistitem extends Eloquent
{
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'masterlistitem';
    protected $dates = ['deleted_at'];
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function masterlists()
    {
        return $this->belongsToMany('App\Masterlist');
    }
}
