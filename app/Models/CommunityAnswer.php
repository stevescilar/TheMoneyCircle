<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityAnswer extends Model
{
    use HasFactory;

    protected $table = 'community_answers';

    protected $fillable = [
        'question_id',
        'member_id',
        'author_name',
        'author_role',
        'body',
        'is_coach_verified',
        'upvotes_count',
    ];

    protected $casts = [
        'is_coach_verified' => 'boolean',
        'upvotes_count' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(CommunityQuestion::class, 'question_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}

