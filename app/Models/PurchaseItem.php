<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class, 'stock_item_id');
    }
}
