<?php

namespace App\Models;
use App\Models\InvestmentContribution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'type', 'label', 'balance'];
    protected $casts = ['balance' => 'decimal:2'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(InvestmentContribution::class);
    }
}