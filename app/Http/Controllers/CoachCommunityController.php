<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CommunityAnswer;
use App\Models\CommunityQuestion;
use App\Models\CommunityWin;
use App\Models\LiveSession;
use App\Models\ResourceItem;
use Database\Seeders\CommunitySeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoachCommunityController extends Controller
{
    // ==========================================
    // ANNOUNCEMENTS
    // ==========================================

    public function announcementsIndex(): View
    {
        $announcements = Announcement::with('coach')
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total' => $announcements->count(),
            'pinned' => $announcements->where('pinned', true)->count(),
            'with_actions' => $announcements->filter(fn($a) => !empty($a->action_label))->count(),
        ];

        return view('coach.community.announcements', compact('announcements', 'stats'));
    }

    public function announcementsStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'pinned' => 'nullable|boolean',
            'action_label' => 'nullable|string|max:100',
            'action_url' => 'nullable|string|max:500',
        ]);

        Announcement::create([
            'coach_id' => $request->user()?->id,
            'title' => $validated['title'],
            'body' => $validated['body'],
            'pinned' => (bool) ($validated['pinned'] ?? false),
            'action_label' => $validated['action_label'] ?: null,
            'action_url' => $validated['action_url'] ?: null,
        ]);

        return back()->with('status', 'Announcement broadcasted successfully to all mobile app members.');
    }

    public function announcementsTogglePin(Announcement $announcement): RedirectResponse
    {
        $announcement->pinned = !$announcement->pinned;
        $announcement->save();

        $state = $announcement->pinned ? 'pinned to the top of' : 'unpinned from';
        return back()->with('status', "Announcement {$state} the community feed.");
    }

    public function announcementsDestroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return back()->with('status', 'Announcement deleted successfully.');
    }

    // ==========================================
    // LIVE SESSIONS
    // ==========================================

    public function liveSessionsIndex(): View
    {
        $upcomingSessions = LiveSession::with('coach')
            ->where('session_time', '>=', now()->subHours(2))
            ->orderBy('session_time')
            ->get();

        $pastSessions = LiveSession::with('coach')
            ->where('session_time', '<', now()->subHours(2))
            ->orderByDesc('session_time')
            ->limit(10)
            ->get();

        $stats = [
            'upcoming_count' => $upcomingSessions->count(),
            'past_count' => $pastSessions->count(),
            'next_session' => $upcomingSessions->first(),
        ];

        return view('coach.community.live-sessions', compact('upcomingSessions', 'pastSessions', 'stats'));
    }

    public function liveSessionsStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'speaker_name' => 'required|string|max:100',
            'session_time' => 'required|date|after_or_equal:today',
            'duration_minutes' => 'required|integer|min:15|max:300',
            'meeting_url' => 'nullable|string|max:500',
        ]);

        LiveSession::create([
            'coach_id' => $request->user()?->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?: null,
            'speaker_name' => $validated['speaker_name'],
            'session_time' => $validated['session_time'],
            'duration_minutes' => (int) $validated['duration_minutes'],
            'meeting_url' => $validated['meeting_url'] ?: null,
        ]);

        return back()->with('status', 'Live coaching session scheduled and published to mobile community.');
    }

    public function liveSessionsDestroy(LiveSession $session): RedirectResponse
    {
        $session->delete();

        return back()->with('status', 'Live coaching session cancelled.');
    }

    // ==========================================
    // RESOURCE LIBRARY
    // ==========================================

    public function resourcesIndex(Request $request): View
    {
        $selectedCategory = $request->query('category');

        $query = ResourceItem::query();
        if ($selectedCategory && in_array($selectedCategory, ['books', 'templates', 'guides'])) {
            $query->where('category', $selectedCategory);
        }

        $resources = $query->latest()->get();

        $counts = [
            'all' => ResourceItem::count(),
            'books' => ResourceItem::where('category', 'books')->count(),
            'templates' => ResourceItem::where('category', 'templates')->count(),
            'guides' => ResourceItem::where('category', 'guides')->count(),
        ];

        return view('coach.community.resources', compact('resources', 'selectedCategory', 'counts'));
    }

    public function resourcesStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:books,templates,guides',
            'file_url' => 'required|string|max:500',
            'author_or_source' => 'nullable|string|max:150',
        ]);

        ResourceItem::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?: null,
            'category' => $validated['category'],
            'file_url' => $validated['file_url'],
            'author_or_source' => $validated['author_or_source'] ?: null,
        ]);

        return back()->with('status', 'Financial resource published to Community Library.');
    }

    public function resourcesDestroy(ResourceItem $resource): RedirectResponse
    {
        $resource->delete();

        return back()->with('status', 'Resource removed from Library.');
    }

    // ==========================================
    // COACH Q&A DESK (PHASE 3)
    // ==========================================

    public function questionsIndex(Request $request): View
    {
        if (CommunityQuestion::count() === 0) {
            (new CommunitySeeder())->run();
        }

        $selectedCategory = $request->query('category');
        $selectedFilter = $request->query('filter', 'all');
        $searchQuery = $request->query('search');

        $query = CommunityQuestion::with(['answers'])
            ->withCount('answers');

        if ($selectedCategory && in_array($selectedCategory, ['saving', 'debt', 'investing', 'budgeting', 'general'])) {
            $query->where('category', $selectedCategory);
        }

        if ($selectedFilter === 'pending_coach') {
            $query->whereDoesntHave('answers', fn($q) => $q->where('is_coach_verified', true));
        } elseif ($selectedFilter === 'coach_answered') {
            $query->whereHas('answers', fn($q) => $q->where('is_coach_verified', true));
        } elseif ($selectedFilter === 'resolved') {
            $query->where('is_resolved', true);
        }

        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('body', 'like', "%{$searchQuery}%")
                  ->orWhere('author_name', 'like', "%{$searchQuery}%");
            });
        }

        $questions = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => CommunityQuestion::count(),
            'pending_coach' => CommunityQuestion::whereDoesntHave('answers', fn($q) => $q->where('is_coach_verified', true))->count(),
            'coach_answered' => CommunityQuestion::whereHas('answers', fn($q) => $q->where('is_coach_verified', true))->count(),
            'resolved' => CommunityQuestion::where('is_resolved', true)->count(),
            'total_answers' => CommunityAnswer::count(),
        ];

        return view('coach.community.questions', compact(
            'questions',
            'stats',
            'selectedCategory',
            'selectedFilter',
            'searchQuery'
        ));
    }

    public function questionsShow(CommunityQuestion $question): View
    {
        $question->load(['answers' => function($q) {
            $q->orderByDesc('is_coach_verified')->latest();
        }, 'member']);

        return view('coach.community.question-detail', compact('question'));
    }

    public function questionsAnswerStore(Request $request, CommunityQuestion $question): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|max:3000',
        ]);

        $coach = $request->user();

        CommunityAnswer::create([
            'question_id' => $question->id,
            'member_id' => null,
            'author_name' => $coach?->name ?? 'Coach Steve',
            'author_role' => 'coach',
            'body' => $validated['body'],
            'is_coach_verified' => true,
            'upvotes_count' => 0,
        ]);

        return back()->with('status', 'Official Coach Verified Answer posted and synced to the mobile app.');
    }

    public function questionsToggleResolve(CommunityQuestion $question): RedirectResponse
    {
        $question->is_resolved = !$question->is_resolved;
        $question->save();

        $status = $question->is_resolved ? 'resolved' : 're-opened';
        return back()->with('status', "Question marked as {$status}.");
    }

    public function questionsDestroy(CommunityQuestion $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('coach.questions.index')->with('status', 'Question discussion removed.');
    }

    public function answersDestroy(CommunityAnswer $answer): RedirectResponse
    {
        $answer->delete();

        return back()->with('status', 'Answer removed from question.');
    }

    // ==========================================
    // WINS WALL MODERATION (PHASE 3)
    // ==========================================

    public function winsIndex(Request $request): View
    {
        if (CommunityWin::count() === 0) {
            (new CommunitySeeder())->run();
        }

        $selectedCategory = $request->query('category');
        $searchQuery = $request->query('search');

        $query = CommunityWin::query();

        if ($selectedCategory && in_array($selectedCategory, ['savings_goal', 'debt_cleared', 'emergency_fund', 'budget_habit', 'general'])) {
            $query->where('category', $selectedCategory);
        }

        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('story', 'like', "%{$searchQuery}%")
                  ->orWhere('member_name', 'like', "%{$searchQuery}%");
            });
        }

        $wins = $query->latest()->paginate(12)->withQueryString();

        $stats = [
            'total_wins' => CommunityWin::count(),
            'total_cheers' => (int) CommunityWin::sum('cheers_count'),
            'total_amount_celebrated' => (float) CommunityWin::sum('amount_celebrated'),
            'debt_cleared_count' => CommunityWin::where('category', 'debt_cleared')->count(),
        ];

        return view('coach.community.wins', compact('wins', 'stats', 'selectedCategory', 'searchQuery'));
    }

    public function winsStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_name' => 'required|string|max:100',
            'title' => 'required|string|max:180',
            'story' => 'required|string|max:1500',
            'category' => 'required|in:savings_goal,debt_cleared,emergency_fund,budget_habit,general',
            'amount_celebrated' => 'nullable|numeric|min:0',
        ]);

        CommunityWin::create([
            'member_name' => $validated['member_name'],
            'title' => $validated['title'],
            'story' => $validated['story'],
            'category' => $validated['category'],
            'amount_celebrated' => $validated['amount_celebrated'] ?: null,
            'cheers_count' => 1,
        ]);

        return back()->with('status', 'Member milestone published to Community Wins Wall!');
    }

    public function winsCheer(CommunityWin $win): RedirectResponse
    {
        $win->increment('cheers_count');

        return back()->with('status', "Cheered {$win->member_name}'s milestone! 🎉");
    }

    public function winsDestroy(CommunityWin $win): RedirectResponse
    {
        $win->delete();

        return back()->with('status', 'Win celebration removed.');
    }
}

