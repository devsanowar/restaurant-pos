<?php

namespace App\Models;

use App\Models\FieldOfCost;
use App\Models\CostCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    
    use SoftDeletes;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(CostCategory::class, 'category_id');
    }

    public function field()
    {
        return $this->belongsTo(FieldOfCost::class, 'field_id');
    }

    
}
