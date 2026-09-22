<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('debts') && !Schema::hasColumn('debts', 'coach_notes')) {
            Schema::table('debts', function (Blueprint $table) {
                $table->text('coach_notes')->nullable();
            });
        }

        if (Schema::hasTable('categories') && !Schema::hasColumn('categories', 'coach_notes')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->text('coach_notes')->nullable();
            });
        }

        if (Schema::hasTable('savings_goals') && !Schema::hasColumn('savings_goals', 'coach_notes')) {
            Schema::table('savings_goals', function (Blueprint $table) {
                $table->text('coach_notes')->nullable();
            });
        }

        if (Schema::hasTable('emergency_funds') && !Schema::hasColumn('emergency_funds', 'coach_notes')) {
            Schema::table('emergency_funds', function (Blueprint $table) {
                $table->text('coach_notes')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('debts') && Schema::hasColumn('debts', 'coach_notes')) {
            Schema::table('debts', function (Blueprint $table) {
                $table->dropColumn('coach_notes');
            });
        }

        if (Schema::hasTable('categories') && Schema::hasColumn('categories', 'coach_notes')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('coach_notes');
            });
        }

        if (Schema::hasTable('savings_goals') && Schema::hasColumn('savings_goals', 'coach_notes')) {
            Schema::table('savings_goals', function (Blueprint $table) {
                $table->dropColumn('coach_notes');
            });
        }

        if (Schema::hasTable('emergency_funds') && Schema::hasColumn('emergency_funds', 'coach_notes')) {
            Schema::table('emergency_funds', function (Blueprint $table) {
                $table->dropColumn('coach_notes');
            });
        }
    }
};

