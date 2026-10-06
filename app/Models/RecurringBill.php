<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'category_id',
        'name',
        'amount',
        'due_day',
        'is_active',
        'last_paid_at',
        'notes',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'due_day'      => 'integer',
        'is_active'    => 'boolean',
        'last_paid_at' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isPaidThisMonth(): bool
    {
        if (! $this->last_paid_at) {
            return false;
        }

        return $this->last_paid_at->isCurrentMonth() && $this->last_paid_at->isCurrentYear();
    }
}

