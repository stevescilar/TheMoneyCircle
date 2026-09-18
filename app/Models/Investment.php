<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'type', 'label', 'balance'];
    protected $casts = ['balance' => 'decimal:2'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}