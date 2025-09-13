<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = ['id'];

    // Relation with PayRoll
    public function payroll()
    {
        return $this->belongsTo(PayRoll::class, 'payroll_id');
    }
}
