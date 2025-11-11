<?php

namespace App\Models\Inc;

use App\Models\Role\Agent;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Agent::class, 'user_id', 'id');
    }
}
