<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('stock_item_id');
            $table->integer('quantity')->default(0.0);
            $table->string('unit')->nullable();
            $table->decimal('unit_price', 12, 2)->default(0.0);
            $table->decimal('total_price', 15, 2)->default(0.0);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
