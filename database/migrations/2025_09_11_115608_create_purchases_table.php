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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('invoice_no')->nullable();
            $table->string('invoice')->nullable();
            $table->string('note')->nullable();
            $table->date('purchase_date');
            $table->decimal('total_price', 15, 2)->default(0.0);
            $table->decimal('discount', 12, 2)->default(0.0);
            $table->decimal('paid_amount', 15, 2)->default(0.0);
            $table->decimal('due_amount', 15, 2)->default(0.0);
            $table->enum('payment_method', ['cash', 'bank', 'mobile_banking', 'credit'])->default('cash');
            $table->string('transaction_no')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
