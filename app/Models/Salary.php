<?php

namespace App\Models;

use App\Models\PayRoll;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(PayRoll::class, 'employee_id', 'id');
    }
}
