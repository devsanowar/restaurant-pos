<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('stock_item_id');
            $table->decimal('item_qty')->default(0.00);
            $table->string('item_unit')->nullable();
            $table->decimal('item_purchase_price')->default(0.00);
            $table->decimal('item_total_price')->default(0.00);
            $table->decimal('total_price')->default(0.00);
            $table->date('stock_entry_date');
            $table->enum('stock_type', ['stock_in', 'stock_out', 'adjustment'])->nullable();
            $table->text('stock_note')->nullable();
            $table->string('invoice')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
