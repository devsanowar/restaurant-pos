<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    protected $guarded = ['id'];

    public function incomes(){
        return $this->hasMany(Income::class, 'income_category_id');
    }
}
