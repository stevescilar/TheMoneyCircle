<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['coach_id', 'name', 'email', 'phone', 'join_date', 'status', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'join_date' => 'date',
        'password' => 'hashed',
    ];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function totalBudgeted(): float
    {
        return (float) $this->categories()->sum('planned_amount');
    }

    public function totalSpent(): float
    {
        return (float) $this->categories->sum(fn (Category $category) => $category->spent());
    }

    public function remainingToSpend(): float
    {
        return (float) $this->totalBudgeted() - $this->totalSpent();
    }

    public function percentBudgetSpent(): float
    {
        if($this->totalBudgeted() == 0){
            return 0;
        }
        return round (($this->totalSpent() / $this->totalBudgeted()) * 100, 1);

    }

    public function isOverSpent(): bool
    {
        return $this->totalSpent() > $this->totalBudgeted();
    }
    
    public function scopeWithBudgetTotals(Builder $query): Builder
    {
        return $query
            ->withSum('categories as total_budgeted', 'planned_amount')
            ->withSum(['transactions as total_spent' => fn ($q) => $q->where('type', 'expense')], 'amount');
    }

    public function scopeAtRisk(Builder $query): Builder
    {
        return $query
            ->withBudgetTotals()
            ->groupBy('members.id')
            ->havingRaw('COALESCE(total_spent, 0) > COALESCE(total_budgeted, 0)');
    }
    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    public function emergencyFund(): HasOne
    {
        return $this->hasOne(EmergencyFund::class);
    }

    public function savingsGoals(): HasMany
    {
        return $this->hasMany(SavingsGoal::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class);
    }

    public function monthlyReflections(): HasMany
    {
        return $this->hasMany(MonthlyReflection::class);
    }
}