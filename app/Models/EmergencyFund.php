<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyFund extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'target_amount', 'current_balance'];
    protected $casts = ['target_amount' => 'decimal:2', 'current_balance' => 'decimal:2'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function percentFunded(): float
    {
        if ((float) $this->target_amount == 0) {
            return 0;
        }

        return round(((float) $this->current_balance / (float) $this->target_amount) * 100, 1);
    }
}