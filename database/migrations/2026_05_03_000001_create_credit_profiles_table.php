<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedInteger('income');
            $table->unsignedInteger('existing_debt');
            $table->unsignedInteger('monthly_expenses');
            $table->string('employment_status');
            $table->string('housing_status')->nullable();
            $table->string('marital_status')->nullable();
            $table->unsignedInteger('dependents')->nullable();
            $table->unsignedInteger('bureau_score')->nullable();
            $table->unsignedInteger('bureau_accounts')->nullable();
            $table->unsignedInteger('bureau_delinquencies')->nullable();
            $table->unsignedInteger('bureau_inquiries')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->string('risk_decision')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_profiles');
    }
};
