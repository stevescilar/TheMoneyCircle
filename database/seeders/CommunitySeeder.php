<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\CommunityAnswer;
use App\Models\CommunityQuestion;
use App\Models\CommunityWin;
use App\Models\LiveSession;
use App\Models\ResourceItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        $coach = User::first();
        $coachId = $coach?->id;

        // 1. Announcements
        if (Announcement::count() === 0) {
            Announcement::create([
                'coach_id' => $coachId,
                'title' => '🎉 Welcome to The Money Circle Community!',
                'body' => 'We are thrilled to have you on board! The Community hub is your space for announcements, weekly live group coaching calls, and our curated financial resource library. Check in weekly to stay inspired on your financial wellness journey.',
                'pinned' => true,
                'action_label' => 'Explore Live Sessions',
                'action_url' => null,
            ]);

            Announcement::create([
                'coach_id' => $coachId,
                'title' => '💡 Tip of the Week: The 72-Hour Rule for Impulse Buys',
                'body' => 'Before making any non-essential purchase over Ksh 3,000, wait 72 hours. If you still feel it brings genuine value to your life, budget for it intentionally. Most impulses fade within 3 days!',
                'pinned' => false,
                'action_label' => null,
                'action_url' => null,
            ]);

            Announcement::create([
                'coach_id' => $coachId,
                'title' => '🚀 Q4 Savings Challenge: Target Ksh 50,000',
                'body' => 'Join our Circle-wide savings sprint towards the end of the year. Set aside Ksh 1,500 every week into your Emergency Fund or Savings Goal.',
                'pinned' => false,
                'action_label' => 'View Challenge Details',
                'action_url' => 'https://microsilsystem.co.ke',
            ]);
        }

        // 2. Live Sessions
        if (LiveSession::count() === 0) {
            LiveSession::create([
                'coach_id' => $coachId,
                'title' => 'Mastering Emergency Funds & High-Yield MMFs',
                'description' => 'Learn how to strategically park 3-6 months of expenses, calculate realistic emergency targets, and compare interest yields among leading Money Market Funds in Kenya.',
                'speaker_name' => 'Coach Steve',
                'session_time' => now()->addDays(2)->setTime(19, 0),
                'duration_minutes' => 60,
                'meeting_url' => 'https://meet.google.com/tmc-live-session',
            ]);

            LiveSession::create([
                'coach_id' => $coachId,
                'title' => 'Debt Payoff Strategies: Snowball vs. Avalanche',
                'description' => 'An interactive breakdown of psychological momentum vs mathematical interest savings. We will build sample repayment roadmaps live.',
                'speaker_name' => 'Coach Steve & Guest Speaker',
                'session_time' => now()->addDays(6)->setTime(18, 30),
                'duration_minutes' => 75,
                'meeting_url' => 'https://meet.google.com/tmc-debt-strategy',
            ]);

            LiveSession::create([
                'coach_id' => $coachId,
                'title' => 'Monthly Group Reflection & Open Q&A Round',
                'description' => 'Bring your monthly wins, challenges, and specific budgeting questions for open coaching and community feedback.',
                'speaker_name' => 'The Money Circle Coaches',
                'session_time' => now()->addDays(12)->setTime(20, 0),
                'duration_minutes' => 60,
                'meeting_url' => 'https://meet.google.com/tmc-reflection-circle',
            ]);
        }

        // 3. Resources
        if (ResourceItem::count() === 0) {
            ResourceItem::create([
                'title' => 'The Psychology of Money (Key Takeaways)',
                'description' => 'Core summaries and behavioral finance insights from Morgan Housel on wealth, greed, and happiness.',
                'category' => 'books',
                'file_url' => 'https://microsilsystem.co.ke/resources/psychology-of-money.pdf',
                'author_or_source' => 'Morgan Housel (Summary by TMC)',
            ]);

            ResourceItem::create([
                'title' => 'Atomic Habits for Financial Discipline',
                'description' => 'How tiny changes in spending and automated savings compound into monumental financial freedom.',
                'category' => 'books',
                'file_url' => 'https://microsilsystem.co.ke/resources/atomic-habits-finance.pdf',
                'author_or_source' => 'James Clear (Study Guide)',
            ]);

            ResourceItem::create([
                'title' => 'Zero-Based Monthly Budget Planner (Excel & Sheets)',
                'description' => 'A ready-to-use template to allocate every shilling of income before the month begins.',
                'category' => 'templates',
                'file_url' => 'https://microsilsystem.co.ke/resources/tmc-budget-planner.xlsx',
                'author_or_source' => 'The Money Circle Team',
            ]);

            ResourceItem::create([
                'title' => 'Debt Snowball & Avalanche Payoff Calculator',
                'description' => 'Calculate your exact debt-free date and see interest saved across different extra payment scenarios.',
                'category' => 'templates',
                'file_url' => 'https://microsilsystem.co.ke/resources/debt-payoff-calculator.xlsx',
                'author_or_source' => 'The Money Circle Team',
            ]);

            ResourceItem::create([
                'title' => 'Beginner Guide to Money Market Funds in Kenya',
                'description' => 'Comparison of CMA-regulated MMFs, management fees, withholding tax, and liquidity rules.',
                'category' => 'guides',
                'file_url' => 'https://microsilsystem.co.ke/resources/kenya-mmf-guide.pdf',
                'author_or_source' => 'TMC Research',
            ]);

            ResourceItem::create([
                'title' => 'The 50/30/20 Budgeting Rule Explained',
                'description' => 'A practical framework to balance Needs (50%), Wants (30%), and Financial Goals (20%) in high-inflation times.',
                'category' => 'guides',
                'file_url' => 'https://microsilsystem.co.ke/resources/50-30-20-guide.pdf',
                'author_or_source' => 'TMC Educational Series',
            ]);
        }

        // 4. Community Questions & Answers
        if (CommunityQuestion::count() === 0) {
            $q1 = CommunityQuestion::create([
                'author_name' => 'Dennis K.',
                'category' => 'investing',
                'title' => 'Should I clear a 14% Sacco loan or invest in an MMF yielding 16% first?',
                'body' => 'I have Ksh 80,000 extra cash. My Sacco development loan charges 14% p.a., while my current MMF yields 16.2% gross. After 15% withholding tax, what makes the most mathematical and psychological sense?',
                'is_resolved' => false,
                'views_count' => 48,
            ]);

            CommunityAnswer::create([
                'question_id' => $q1->id,
                'author_name' => $coach?->name ?? 'Coach Steve',
                'author_role' => 'coach',
                'is_coach_verified' => true,
                'body' => "Great question Dennis! Let's do the exact math:\n16.2% gross on MMF minus 15% withholding tax = 13.77% net return. Your Sacco loan is costing you 14.0% p.a.\n\nFrom a purely mathematical standpoint, the loan payoff wins by ~0.23%. More importantly, paying off the debt gives you a GUARANTEED 14% tax-free return with ZERO volatility. I recommend wiping out the Sacco debt first, then redirecting that monthly installment straight into your MMF compounding machine!",
                'upvotes_count' => 14,
            ]);

            CommunityAnswer::create([
                'question_id' => $q1->id,
                'author_name' => 'Mary N.',
                'author_role' => 'member',
                'is_coach_verified' => false,
                'body' => 'I was in the exact same position 6 months ago. Clearing the debt freed up my mental bandwidth so much. The feeling of zero debt is unmatched!',
                'upvotes_count' => 5,
            ]);

            $q2 = CommunityQuestion::create([
                'author_name' => 'Mercy A.',
                'category' => 'budgeting',
                'title' => 'How do you budget for irregular / fluctuating freelance income?',
                'body' => 'Some months I bring in Ksh 120k, other months Ksh 40k. What budgeting system prevents lifestyle creep during high-earning months while avoiding stress in lean months?',
                'is_resolved' => true,
                'views_count' => 64,
            ]);

            CommunityAnswer::create([
                'question_id' => $q2->id,
                'author_name' => $coach?->name ?? 'Coach Steve',
                'author_role' => 'coach',
                'is_coach_verified' => true,
                'body' => "Hi Mercy! For variable freelance income, use the 'Buffer Account & Baseline Salary' method:\n1. Calculate your bare-minimum baseline living expenses (e.g. Ksh 45k).\n2. Deposit all client payments into a dedicated 'Holding/Buffer Account'.\n3. Pay yourself a fixed salary of Ksh 45k on the 1st of every month from that buffer.\n4. In bumper months (e.g. 120k), the surplus remains in the buffer to float lean months. Every quarter, review the excess and sweep 50% into investments and 50% into a bonus!",
                'upvotes_count' => 22,
            ]);

            CommunityQuestion::create([
                'author_name' => 'David N.',
                'category' => 'saving',
                'title' => 'Emergency Fund: How many months is safe in current economic times?',
                'body' => 'Is 3 months of basic living expenses sufficient, or should households with dependents target 6 months considering Kenyan job market hiring cycles?',
                'is_resolved' => false,
                'views_count' => 18,
            ]);

            CommunityQuestion::create([
                'author_name' => 'Jane W.',
                'category' => 'debt',
                'title' => 'Credit card vs Mobile Loan: which to attack first?',
                'body' => 'I have an overdraft balance with 18% APR and a mobile loan with monthly facility fees. The mobile loan is smaller. Should I use Snowball or Avalanche?',
                'is_resolved' => false,
                'views_count' => 29,
            ]);
        }

        // 5. Community Wins
        if (CommunityWin::count() === 0) {
            CommunityWin::create([
                'member_name' => 'Wanjiku M.',
                'category' => 'debt_cleared',
                'title' => 'Cleared my Stanbic Credit Card in Full! 🎉',
                'story' => 'After 8 months of aggressive debt snowballing and packing lunch to work, I made my final Ksh 12,500 payment today! Zero high-interest debt remaining. The psychological relief is unbelievable!',
                'amount_celebrated' => 45000.00,
                'cheers_count' => 24,
            ]);

            CommunityWin::create([
                'member_name' => 'Brian O.',
                'category' => 'emergency_fund',
                'title' => 'Hit 3-Month Emergency Fund Cushion! 🛡️',
                'story' => 'My target was Ksh 150,000 safely parked in a top MMF. Setting up an automated standing order on payday made it painless. Huge thanks to Coach Steve for the budgeting guidance!',
                'amount_celebrated' => 150000.00,
                'cheers_count' => 31,
            ]);

            CommunityWin::create([
                'member_name' => 'Faith K.',
                'category' => 'savings_goal',
                'title' => 'Reached First Ksh 50,000 in Savings Goal! 🎯',
                'story' => 'Joined the Circle sprint and stuck to weekly deposits of Ksh 2,500. This is the first time I have maintained savings without raiding the account!',
                'amount_celebrated' => 50000.00,
                'cheers_count' => 19,
            ]);

            CommunityWin::create([
                'member_name' => 'Kevin M.',
                'category' => 'budget_habit',
                'title' => '30 Days of Zero Unbudgeted Impulse Purchases! ⚡',
                'story' => 'Practicing the 72-hour delay rule transformed how I view discretionary spending. Avoided 4 unnecessary gadget buys and redirected Ksh 14,000 straight to investments.',
                'amount_celebrated' => null,
                'cheers_count' => 16,
            ]);
        }
    }
}

