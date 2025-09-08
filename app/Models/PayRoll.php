<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{
    protected $guarded = ['id'];
    public function restaurant()
    {
        return $this->belongsTo(RestaurantBranch::class, 'restaurant_id');
    }
}
