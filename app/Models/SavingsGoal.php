<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'goal_name', 'target_amount', 'saved_amount'];
    protected $casts = ['target_amount' => 'decimal:2', 'saved_amount' => 'decimal:2'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function remaining(): float
    {
        return (float) $this->target_amount - (float) $this->saved_amount;
    }

    public function percentComplete(): float
    {
        if ((float) $this->target_amount == 0) {
            return 0;
        }

        return round(((float) $this->saved_amount / (float) $this->target_amount) * 100, 1);
    }
}