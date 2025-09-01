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
        Schema::table('sms_api_settings', function (Blueprint $table) {
            $table->dropColumn('request_type'); // Column remove করার জন্য
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_api_settings', function (Blueprint $table) {
            $table->string('request_type');
        });
    }
};
