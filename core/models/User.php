<?php

namespace Ultra\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    public $table = 'users';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * setPasswordAttribute Define encrypted password
     * @param void $value string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = hash('sha256', $value);
    }
}