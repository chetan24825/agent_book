<?php

namespace App\Models\Role;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin  extends Authenticatable
{
    public $table = 'admins';

    protected $guard = 'admin'; // Set the guard explicitly

    protected $fillable = [];

    protected $hidden = [
        'password',
    ];
}
