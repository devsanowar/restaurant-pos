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
        Schema::create('advance_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employe_id');
            $table->date('adv_payment_date');
            $table->string('month_name');
            $table->decimal('salary', 10, 2)->default(0.0);
            $table->decimal('adv_paid', 10, 2)->default(0.0);
            $table->decimal('remaining_sallery', 10, 2)->default(0.0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_payments');
    }
};
