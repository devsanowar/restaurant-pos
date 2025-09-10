<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function table()
    {
        return $this->belongsTo(ResTable::class, 'res_table_id');
    }

    public function waiter()
    {
        return $this->belongsTo(Waiter::class, 'waiter_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
