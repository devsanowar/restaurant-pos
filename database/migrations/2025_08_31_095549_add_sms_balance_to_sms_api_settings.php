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
        Schema::table('sms_api_settings', function (Blueprint $table) {
            $table->integer('total_sms')->default(0);
            $table->integer('used_sms')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_api_settings', function (Blueprint $table) {
            //
        });
    }
};
