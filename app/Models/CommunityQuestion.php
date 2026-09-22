<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityQuestion extends Model
{
    use HasFactory;

    protected $table = 'community_questions';

    protected $fillable = [
        'member_id',
        'author_name',
        'title',
        'body',
        'category',
        'is_resolved',
        'views_count',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'views_count' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function answers()
    {
        return $this->hasMany(CommunityAnswer::class, 'question_id')->orderBy('is_coach_verified', 'desc')->latest();
    }
}

