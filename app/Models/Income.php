<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

}
