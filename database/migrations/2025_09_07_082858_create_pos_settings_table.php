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
        Schema::create('pos_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('currency',['BDT','USD','INR','EUR'])->default('BDT');
            $table->decimal('tax_rate')->nullable();
            $table->decimal('service_charge')->nullable();
            $table->enum('default_printer',['pos_printer', 'kitchen_printer'])->default('pos_printer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_settings');
    }
};
