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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Company Settings
            $table->string('company_name')->default('Revoke');
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->text('company_address')->nullable();
            
            // General Settings
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('M d, Y');
            $table->string('currency')->default('USD');
            
            // Notification Settings
            $table->boolean('notify_offboarding')->default(true);
            $table->boolean('notify_high_risk')->default(true);
            $table->boolean('notify_reports')->default(true);
            $table->string('notification_email')->nullable();
            
            // Report Settings
            $table->boolean('auto_generate_reports')->default(false);
            $table->string('report_frequency')->default('monthly'); // weekly, monthly, quarterly
            
            // Security Settings
            $table->boolean('enable_two_factor')->default(false);
            $table->integer('session_timeout')->default(60); // minutes
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
