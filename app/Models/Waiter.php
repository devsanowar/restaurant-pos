<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    protected $guarded = ['id'];

    public function table()
    {
        return $this->belongsTo(ResTable::class, 'res_table_id');
    }

}
