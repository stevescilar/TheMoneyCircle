<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\HasMany;

class DebtPayment extends Model
{
    use HasFactory;

    protected $fillable = ['debt_id', 'amount', 'paid_at'];
    protected $casts = ['paid_at' => 'date', 'amount' => 'decimal:2'];

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }
    // public function payments(): HasMany
    // {
    //     return $this->hasMany(DebtPayment::class);
    // }
}