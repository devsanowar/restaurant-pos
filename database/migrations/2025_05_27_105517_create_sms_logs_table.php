<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->text('message')->nullable();
            $table->integer('total_characters')->nullable();
            $table->integer('total_message')->nullable();
            $table->string('delivery_report')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
