<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'lender', 'current_balance', 'target_payoff_date'];
    protected $casts = ['target_payoff_date' => 'date', 'current_balance' => 'decimal:2'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function monthsUntilTargetPayoff(): ?int
    {
        if (! $this->target_payoff_date) {
            return null;
        }

        return max(0, (int) now()->diffInMonths($this->target_payoff_date, false));
    }

    public function requiredMonthlyPayment(): ?float
    {
        $months = $this->monthsUntilTargetPayoff();

        if ($months === null) {
            return null;
        }

        if ($months === 0) {
            return (float) $this->current_balance;
        }

        return round((float) $this->current_balance / $months, 2);
    }
    
}