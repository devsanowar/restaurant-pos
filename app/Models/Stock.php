<?php

namespace App\Models;

use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function purchaseItems()
{
    return $this->hasMany(PurchaseItem::class, 'stock_id');
}
}
