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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'loan_type')) {
                $table->string('loan_type')->nullable()->after('mobile_number');
                $table->string('city')->nullable()->after('loan_type');
                $table->decimal('monthly_yield', 15, 2)->nullable()->after('city');
                $table->string('vehicle_make')->nullable()->after('monthly_yield');
                $table->string('vehicle_model')->nullable()->after('vehicle_make');
                $table->string('mfg_year')->nullable()->after('vehicle_model');
                $table->string('fuel_type')->nullable()->after('mfg_year');
                $table->decimal('asset_value', 15, 2)->nullable()->after('fuel_type');
                $table->string('pan_number')->nullable()->after('asset_value');
                $table->string('aadhaar_number')->nullable()->after('pan_number');
                $table->json('documents')->nullable()->after('aadhaar_number');
                $table->json('rc_documents')->nullable()->after('documents');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'loan_type', 'city', 'monthly_yield', 'vehicle_make', 
                'vehicle_model', 'mfg_year', 'fuel_type', 'asset_value', 
                'pan_number', 'aadhaar_number', 'documents', 'rc_documents'
            ]);
        });
    }
};
