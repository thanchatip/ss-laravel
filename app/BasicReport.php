<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class BasicReport extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'basicReportSetting';

    const CREATED_AT = 'data.createdAt';
    const UPDATED_AT = 'data.updatedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
}
