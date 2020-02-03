<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class RoleCode extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'roleCode';


}
