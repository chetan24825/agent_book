<?php

namespace App\Models\Role;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Authenticatable
{

    public $table = 'agents';

    protected $guard = 'agent'; // Set the guard explicitly

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];
}
