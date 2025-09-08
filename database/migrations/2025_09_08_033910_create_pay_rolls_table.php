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
        Schema::create('pay_rolls', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->foreignId('restaurant_id')->constrained('restaurant_branches')->onDelete('cascade');
            $table->date('joining_date');
            $table->string('employe_name');
            $table->string('employe_phone');
            $table->string('employe_email');
            $table->string('employe_nid_number');
            $table->string('employe_blood_group', 5)->nullable();
            $table->string('employe_nid_front_image');
            $table->string('employe_nid_back_image');
            $table->date('employe_date_of_birth')->nullable();
            $table->json('employe_edu_qualification')->nullable();
            $table->string('employe_father_name')->nullable();
            $table->string('employe_mother_name')->nullable();
            $table->text('employe_present_address')->nullable();
            $table->text('employe_permanent_address')->nullable();
            $table->tinyInteger('gender')->nullable(); // 0=male,1=female
            $table->string('employe_designation')->nullable();
            $table->decimal('employe_sallery', 10, 2)->nullable();
            $table->decimal('employe_festival_bonas', 10, 2)->nullable();
            $table->enum('employe_festival_bonas_type', ['cash', 'product'])->nullable(); // enum values must not be empty
            $table->decimal('employe_overtime_rate', 10, 2)->nullable();
            $table->string('employe_yearly_leave')->nullable();
            $table->string('employe_image')->nullable();
            $table->string('employe_resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_rolls');
    }
};
