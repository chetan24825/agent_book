<?php

namespace App\Models\Inc;

use App\Models\Role\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityDeposit extends Model
{
    use SoftDeletes;
    protected $table = 'security_deposits';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }
}
