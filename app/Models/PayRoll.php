<?php

namespace App\Models;

use App\Models\Attendance;
use App\Models\AdvancePayment;
use App\Models\RestaurantBranch;
use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{
    protected $guarded = ['id'];
    public function restaurant()
    {
        return $this->belongsTo(RestaurantBranch::class, 'restaurant_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'payroll_id');
    }

    public function advancePayments()
    {
        return $this->hasMany(AdvancePayment::class, 'employe_id');
    }
}
