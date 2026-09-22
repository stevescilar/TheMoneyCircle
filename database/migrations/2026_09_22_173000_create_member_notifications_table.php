<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('member_notifications')) {
            Schema::create('member_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained()->cascadeOnDelete();
                $table->string('type')->default('general'); // debt_note, category_note, reflection_note, savings_note
                $table->string('title');
                $table->text('message');
                $table->string('action_target')->nullable(); // 'debts', 'categories', 'reflections', etc.
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('member_notifications');
    }
};

