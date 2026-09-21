<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'planned_amount', 'type', 'period_start', 'period_end',
    ];

    protected $casts = [
        'period_start'=>'date',
        'period_end'=>'date',
        'planned_amount'=>'decimal:2',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function spent(): float
    {
        return (float) $this->transactions()->where('type','expense')->sum('amount');
    }

    public function remaining():float
    {
        return (float) $this->planned_amount - $this->spent();
    }

    public function percentageComplete(): float
    {
        if ((float) $this->planned_amount == 0){
            return 0;
        }
        return round(($this->spent() / (float) $this->planned_amount) *100,1);
    }
}
