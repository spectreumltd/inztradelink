<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->string('slug');
            $table->string('icon', 50)->nullable();
            $table->longText('description')->nullable();
            $table->double('monthly_amount', 8, 2)->nullable();
            $table->double('half_yearly_amount')->nullable();
            $table->double('yearly_amount', 8, 2)->nullable();
            $table->double('per_month_amount', 8, 2)->nullable();
            $table->tinyInteger('is_status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
