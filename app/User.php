<?php namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Eloquent implements Authenticatable ,CanResetPasswordContract
{
    
    use AuthenticableTrait , CanResetPassword;
    use EntrustUserTrait { restore as private restoreA; }
    use SoftDeletes  { restore as private restoreB; } 

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';
    protected $collection = 'users';
    protected $dates = ['deleted_at'];
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'prefix',
        'firstname', 
        'lastname',
        'email',
        'password',
        'code',
        'position',
        'department',
        'zone_id',
        'start_work',
        'allowCreateForm' 
    ];


    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')->whereNull('deleted_at');
    }

    public function forms()
    {
        return $this->belongsToMany('App\Form');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function masterlists()
    {
        return $this->belongsToMany('App\Masterlist');
    }

    public function masterdata()
    {
        return $this->belongsToMany('App\Masterdata');
    }

}
