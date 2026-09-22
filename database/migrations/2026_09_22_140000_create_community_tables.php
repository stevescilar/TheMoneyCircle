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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('body');
            $table->boolean('pinned')->default(false);
            $table->string('action_label')->nullable();
            $table->string('action_url')->nullable();
            $table->timestamps();
        });

        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('speaker_name')->default('Coach');
            $table->dateTime('session_time');
            $table->integer('duration_minutes')->default(60);
            $table->string('meeting_url')->nullable();
            $table->timestamps();
        });

        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['books', 'templates', 'guides'])->default('guides');
            $table->string('file_url')->nullable();
            $table->string('author_or_source')->nullable();
            $table->timestamps();
        });

        Schema::create('community_wins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('member_name');
            $table->enum('category', ['savings_goal', 'debt_cleared', 'emergency_fund', 'budget_habit', 'general'])->default('general');
            $table->string('title');
            $table->text('story');
            $table->decimal('amount_celebrated', 12, 2)->nullable();
            $table->integer('cheers_count')->default(0);
            $table->timestamps();
        });

        Schema::create('community_win_cheers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('win_id')->constrained('community_wins')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->unique(['win_id', 'member_id']);
            $table->timestamps();
        });

        Schema::create('community_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('author_name');
            $table->string('title');
            $table->text('body');
            $table->enum('category', ['saving', 'debt', 'investing', 'budgeting', 'general'])->default('general');
            $table->boolean('is_resolved')->default(false);
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });

        Schema::create('community_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('community_questions')->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('author_name');
            $table->enum('author_role', ['coach', 'member', 'admin'])->default('member');
            $table->text('body');
            $table->boolean('is_coach_verified')->default(false);
            $table->integer('upvotes_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_answers');
        Schema::dropIfExists('community_questions');
        Schema::dropIfExists('community_win_cheers');
        Schema::dropIfExists('community_wins');
        Schema::dropIfExists('resources');
        Schema::dropIfExists('live_sessions');
        Schema::dropIfExists('announcements');
    }
};

