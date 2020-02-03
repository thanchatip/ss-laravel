<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class Question extends Eloquent
{

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'questions';

    protected $fillable = [
        'question',
        'created_by'
    ];

    public function answers()
    {
        return $this->belongsToMany('App\Answer');
    }

    public function masterlists()
    {
        return $this->belongsToMany('App\Masterlist');
    }


}