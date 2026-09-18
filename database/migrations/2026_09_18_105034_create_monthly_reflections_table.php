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
        Schema::create('monthly_reflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('financial_score'); // 1-10
            $table->text('wins')->nullable();
            $table->text('challenges')->nullable();
            $table->text('coach_notes')->nullable();
            $table->date('period_month'); // first day of the month this reflection covers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reflections');
    }
};
