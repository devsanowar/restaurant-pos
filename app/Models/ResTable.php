<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResTable extends Model
{
    protected $guarded = ['id'];

    public function waiter()
    {
        return $this->belongsTo(Waiter::class, 'waiter_id');
    }

    public function waiters()
    {
        return $this->hasMany(Waiter::class, 'res_table_id');
    }

}
