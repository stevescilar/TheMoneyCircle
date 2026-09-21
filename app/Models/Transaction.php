<?php

namespace App\Models;
use App\Models\Member;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'type', 'amount', 'description', 'transacted_at'
    ];

    protected $casts = [
        'transacted_at' => 'date',
        'amount' => 'decimal:2',
    ];

    public function member():BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}