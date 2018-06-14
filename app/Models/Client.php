<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\ClientResetPassword;

class Client extends Authenticatable
{
    // use AuthenticatesUsers;
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $guard = 'client';

    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    // protected $dates = [];
     protected $fillable = [
        'name', 'password', 'telephone','role_name','email'
    ];

    protected $hidden = [
        'password','remember_token'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'role_clients', 'client_id', 'role_id');
    }

    public function kindergarten()
    {
        return $this->belongsToMany('App\Models\KinderGarten', 'kindergarten_clients', 'client_id', 'kindergarten_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Children','client_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPassword($token));
    }
}
