<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('artisan admin:create can create a new super admin', function () {
    $this->artisan('admin:create', [
        '--name' => 'Root Administrator',
        '--email' => 'superadmin@example.com',
        '--password' => 'SecurePass123!',
        '--title' => 'Chief Executive & Super Admin',
    ])->assertSuccessful();

    $user = User::where('email', 'superadmin@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Root Administrator')
        ->and($user->role)->toBe('super_admin')
        ->and($user->isSuperAdmin())->toBeTrue()
        ->and($user->hasVerifiedEmail())->toBeTrue()
        ->and(Hash::check('SecurePass123!', $user->password))->toBeTrue();
});

test('artisan admin:create can promote an existing coach to super admin', function () {
    $coach = User::factory()->create([
        'name' => 'Standard Coach',
        'email' => 'standardcoach@example.com',
        'password' => Hash::make('old-password'),
        'role' => 'coach',
    ]);

    $this->artisan('admin:create', [
        '--name' => 'Promoted Coach Admin',
        '--email' => 'standardcoach@example.com',
        '--password' => 'NewAdminPass123!',
        '--title' => 'Lead Super Admin',
    ])->assertSuccessful();

    $coach->refresh();
    expect($coach->role)->toBe('super_admin')
        ->and($coach->isSuperAdmin())->toBeTrue()
        ->and($coach->name)->toBe('Promoted Coach Admin')
        ->and(Hash::check('NewAdminPass123!', $coach->password))->toBeTrue();
});

test('authenticated user accessing /dashboard is redirected to coach dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('coach.dashboard'));
});

test('super admin sees super admin badge on profile page and sidebar', function () {
    $admin = User::factory()->create([
        'name' => 'Executive Admin',
        'email' => 'admin@circle.com',
        'role' => 'super_admin',
    ]);

    $response = $this->actingAs($admin)->get(route('profile.edit'));

    $response->assertOk();
    $response->assertSee('SUPER ADMIN');

    $dashboardResponse = $this->actingAs($admin)->get(route('coach.dashboard'));
    $dashboardResponse->assertOk();
    $dashboardResponse->assertSee('Admin');
});

