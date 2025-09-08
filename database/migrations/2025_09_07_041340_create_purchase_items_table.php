<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id'); // master stock reference
            $table->unsignedBigInteger('stock_item_id'); // actual item id
            $table->decimal('item_qty', 12, 2)->default(0.0);
            $table->string('item_unit')->nullable();
            $table->decimal('item_purchase_price', 12, 2)->default(0.0);
            $table->decimal('item_total_price', 12, 2)->default(0.0);
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');
            $table->foreign('stock_item_id')->references('id')->on('stock_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
