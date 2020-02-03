<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class Flatdata extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'flatData';
}
