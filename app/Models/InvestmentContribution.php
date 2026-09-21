<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentContribution extends Model
{
    use HasFactory;

    protected $fillable = ['investment_id', 'amount', 'contributed_at'];
    protected $casts = ['contributed_at' => 'date', 'amount' => 'decimal:2'];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }
    
}