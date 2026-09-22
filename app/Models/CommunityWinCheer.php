<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

