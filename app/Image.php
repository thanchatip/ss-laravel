<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class Image extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'images';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'image' ];
}
