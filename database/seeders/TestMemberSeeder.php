<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Debt;
use App\Models\DebtPayment;
use App\Models\EmergencyFund;
use App\Models\Investment;
use App\Models\InvestmentContribution;
use App\Models\Member;
use App\Models\MonthlyReflection;
use App\Models\SavingsGoal;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestMemberSeeder extends Seeder
{
    public function run(): void
    {
        $coach = User::first();
        if (!$coach) {
            $coach = User::create([
                'name' => 'Coach Steve',
                'title' => 'Lead Wealth Coach',
                'email' => 'coach@themoneycircle.com',
                'role' => 'coach',
                'phone' => '+254700000001',
                'bio' => 'Empowering individuals to master personal finances, clear debts, and build generational wealth.',
                'specialties' => 'Budgeting, Debt Elimination, Wealth Building',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }

        // Create or update the test member
        $member = Member::updateOrCreate(
            ['email' => 'member@test.com'],
            [
                'coach_id' => $coach->id,
                'name' => 'Jane Doe',
                'phone' => '+254712345678',
                'join_date' => now()->subMonths(3)->toDateString(),
                'status' => 'active',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'verification_code' => null,
            ]
        );

        // 1. Categories
        $categoriesData = [
            ['name' => 'Rent & Housing', 'planned_amount' => 25000, 'type' => 'expense'],
            ['name' => 'Groceries & Food', 'planned_amount' => 15000, 'type' => 'expense'],
            ['name' => 'Utilities & Internet', 'planned_amount' => 6000, 'type' => 'expense'],
            ['name' => 'Transport & Fuel', 'planned_amount' => 8000, 'type' => 'expense'],
            ['name' => 'Entertainment & Dining', 'planned_amount' => 5000, 'type' => 'expense'],
        ];

        $now = now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['name']] = Category::updateOrCreate(
                [
                    'member_id' => $member->id,
                    'name' => $cat['name'],
                ],
                [
                    'planned_amount' => $cat['planned_amount'],
                    'type' => $cat['type'],
                    'period_start' => $startOfMonth,
                    'period_end' => $endOfMonth,
                ]
            );
        }

        // 2. Transactions
        if ($member->transactions()->count() === 0) {
            // Income
            Transaction::create([
                'member_id' => $member->id,
                'category_id' => null,
                'type' => 'income',
                'amount' => 95000,
                'description' => 'Monthly Salary',
                'transacted_at' => $now->copy()->startOfMonth()->addDays(2)->toDateString(),
            ]);

            // Expenses
            Transaction::create([
                'member_id' => $member->id,
                'category_id' => $categories['Rent & Housing']->id,
                'type' => 'expense',
                'amount' => 25000,
                'description' => 'Apartment Rent payment',
                'transacted_at' => $now->copy()->startOfMonth()->addDays(3)->toDateString(),
            ]);

            Transaction::create([
                'member_id' => $member->id,
                'category_id' => $categories['Groceries & Food']->id,
                'type' => 'expense',
                'amount' => 8400,
                'description' => 'Supermarket shopping',
                'transacted_at' => $now->copy()->startOfMonth()->addDays(5)->toDateString(),
            ]);

            Transaction::create([
                'member_id' => $member->id,
                'category_id' => $categories['Utilities & Internet']->id,
                'type' => 'expense',
                'amount' => 4500,
                'description' => 'WiFi & Electricity bill',
                'transacted_at' => $now->copy()->startOfMonth()->addDays(6)->toDateString(),
            ]);

            Transaction::create([
                'member_id' => $member->id,
                'category_id' => $categories['Transport & Fuel']->id,
                'type' => 'expense',
                'amount' => 4200,
                'description' => 'Fuel refill',
                'transacted_at' => $now->copy()->startOfMonth()->addDays(7)->toDateString(),
            ]);
        }

        // 3. Emergency Fund
        EmergencyFund::updateOrCreate(
            ['member_id' => $member->id],
            [
                'target_amount' => 150000,
                'current_balance' => 45000,
            ]
        );

        // 4. Savings Goals
        SavingsGoal::updateOrCreate(
            ['member_id' => $member->id, 'goal_name' => 'Land Purchase Deposit'],
            [
                'target_amount' => 200000,
                'saved_amount' => 65000,
            ]
        );

        SavingsGoal::updateOrCreate(
            ['member_id' => $member->id, 'goal_name' => 'December Family Vacation'],
            [
                'target_amount' => 40000,
                'saved_amount' => 15000,
            ]
        );

        // 5. Debts
        $loan = Debt::updateOrCreate(
            ['member_id' => $member->id, 'lender' => 'Equity Bank Loan'],
            [
                'current_balance' => 65000,
                'target_payoff_date' => now()->addMonths(10)->toDateString(),
            ]
        );

        if ($loan->payments()->count() === 0) {
            DebtPayment::create([
                'debt_id' => $loan->id,
                'amount' => 7500,
                'paid_at' => now()->subMonth(),
            ]);
        }

        Debt::updateOrCreate(
            ['member_id' => $member->id, 'lender' => 'M-Shwari Micro Loan'],
            [
                'current_balance' => 4500,
                'target_payoff_date' => now()->addMonth()->toDateString(),
            ]
        );

        // 6. Investments
        $mmf = Investment::updateOrCreate(
            ['member_id' => $member->id, 'label' => 'Sanlam Money Market Fund'],
            [
                'type' => 'mmf',
                'balance' => 75000,
            ]
        );

        if ($mmf->contributions()->count() === 0) {
            InvestmentContribution::create([
                'investment_id' => $mmf->id,
                'amount' => 50000,
                'contributed_at' => now()->subMonths(2),
            ]);
            InvestmentContribution::create([
                'investment_id' => $mmf->id,
                'amount' => 25000,
                'contributed_at' => now()->subMonth(),
            ]);
        }

        $sacco = Investment::updateOrCreate(
            ['member_id' => $member->id, 'label' => 'Stima Sacco Deposits'],
            [
                'type' => 'sacco',
                'balance' => 40000,
            ]
        );

        if ($sacco->contributions()->count() === 0) {
            InvestmentContribution::create([
                'investment_id' => $sacco->id,
                'amount' => 40000,
                'contributed_at' => now()->subMonths(3),
            ]);
        }

        Investment::updateOrCreate(
            ['member_id' => $member->id, 'label' => 'NSE Safaricom Shares'],
            [
                'type' => 'shares',
                'balance' => 20000,
            ]
        );

        // 7. Monthly Reflection
        MonthlyReflection::updateOrCreate(
            [
                'member_id' => $member->id,
                'period_month' => now()->copy()->startOfMonth()->toDateString(),
            ],
            [
                'financial_score' => 8,
                'wins' => 'Consistently added Ksh 25,000 to MMF and stuck to grocery budget.',
                'challenges' => 'Car service was higher than planned.',
                'coach_notes' => 'Great discipline Jane! Keep the momentum on your emergency fund.',
            ]
        );
    }
}
