<?php

namespace App\Models;

use App\Models\PayRoll;
use Illuminate\Database\Eloquent\Model;

class RestaurantBranch extends Model
{
    protected $guarded = ['id'];

    public function employees()
    {
        return $this->hasMany(PayRoll::class, 'restaurant_id');
    }
}
