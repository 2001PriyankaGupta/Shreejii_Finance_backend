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
        Schema::table('employee_details', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('reference_1_name')->nullable();
            $table->string('reference_1_phone')->nullable();
            $table->string('reference_2_name')->nullable();
            $table->string('reference_2_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'referral_code',
                'account_holder',
                'reference_1_name',
                'reference_1_phone',
                'reference_2_name',
                'reference_2_phone',
            ]);
        });
    }
};
