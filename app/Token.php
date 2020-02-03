<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class Token extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'tokens';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'user_id', 
        'access_token', 
        'app_key', 
        'device_name', 
        'expire_date', 
        'status' 
    ];


}
