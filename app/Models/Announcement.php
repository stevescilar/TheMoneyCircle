<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'title',
        'body',
        'pinned',
        'action_label',
        'action_url',
    ];

    protected $casts = [
        'pinned' => 'boolean',
    ];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'title',
        'description',
        'speaker_name',
        'session_time',
        'duration_minutes',
        'meeting_url',
    ];

    protected $casts = [
        'session_time' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}

class ResourceItem extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'title',
        'description',
        'category',
        'file_url',
        'author_or_source',
    ];
}

class CommunityWin extends Model
{
    use HasFactory;

    protected $table = 'community_wins';

    protected $fillable = [
        'member_id',
        'member_name',
        'category',
        'title',
        'story',
        'amount_celebrated',
        'cheers_count',
    ];

    protected $casts = [
        'amount_celebrated' => 'decimal:2',
        'cheers_count' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function cheers()
    {
        return $this->hasMany(CommunityWinCheer::class, 'win_id');
    }
}

class CommunityWinCheer extends Model
{
    use HasFactory;

    protected $table = 'community_win_cheers';

    protected $fillable = [
        'win_id',
        'member_id',
    ];

    public function win()
    {
        return $this->belongsTo(CommunityWin::class, 'win_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}

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

