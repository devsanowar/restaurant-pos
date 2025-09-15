<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_item_id');
            $table->integer('quantity')->default(0);
            $table->string('unit')->default('pcs');
            $table->string('received_by')->nullable();
            $table->string('reason')->nullable();
            $table->date('stock_out_date')->nullable();
            $table->timestamps();

            $table->foreign('stock_item_id')->references('id')->on('stocks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
