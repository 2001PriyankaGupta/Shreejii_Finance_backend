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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The creator (Partner/Employee)
            $table->string('customer_name');
            $table->string('mobile_number');
            $table->decimal('loan_amount', 15, 2);
            $table->string('status')->default('OPEN'); // OPEN, IN PROGRESS, CONVERTED, LOST
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
