<?php

namespace App\Models;

use App\Models\Orderitem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany(Orderitem::class);
    }
}
