<?php

namespace App\Models\Orders;

use App\Models\Role\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function sponsor()
    {
        return $this->belongsTo(Agent::class, 'commission_user_id', 'id');
    }
}
