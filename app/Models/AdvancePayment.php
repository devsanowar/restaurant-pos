<?php

namespace App\Models;

use App\Models\PayRoll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvancePayment extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

     public function employe()
    {
        return $this->belongsTo(PayRoll::class, 'employe_id');
    }

}
