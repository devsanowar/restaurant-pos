<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories')->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('costing_price', 10, 2);
            $table->decimal('sales_price', 10, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['In Stock', 'Out of Stock'])->default('In Stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
