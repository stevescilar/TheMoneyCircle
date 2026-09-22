<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

