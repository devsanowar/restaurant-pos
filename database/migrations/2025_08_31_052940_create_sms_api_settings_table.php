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
        Schema::create('sms_api_settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_url', 255);
            $table->string('api_key', 255);
            $table->string('api_secret', 255)->nullable();
            $table->string('sender_id', 100)->nullable();
            $table->enum('request_type', ['GET', 'POST'])->default('POST');
            $table->enum('message_type', ['TEXT', 'UNICODE', 'FLASH', 'WAPPUSH'])->default('TEXT');
            $table->text('default_message')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_api_settings');
    }
};
