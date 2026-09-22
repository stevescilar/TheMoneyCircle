<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyReflection extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'period_month',
        'financial_score',
        'wins',
        'challenges',
        'coach_notes',
    ];

    protected $casts = [
        'period_month' => 'date',
        'financial_score' => 'integer',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}