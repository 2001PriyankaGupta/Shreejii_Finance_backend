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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('loan_type');
            $table->decimal('monthly_income', 15, 2)->nullable();
            $table->string('city')->nullable();
            $table->string('current_city')->nullable();
            $table->decimal('loan_amount', 15, 2);
            $table->string('tenure')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('employer_name')->nullable();
            $table->decimal('existing_emis', 15, 2)->default(0);
            $table->string('customer_name')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_image')->nullable();
            $table->string('aadhaar_front_image')->nullable();
            $table->string('aadhaar_back_image')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('status')->default('PENDING'); // PENDING, APPROVED, REJECTED, DISBURSED
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
