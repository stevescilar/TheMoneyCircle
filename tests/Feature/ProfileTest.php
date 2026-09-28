<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('coach profile fields including title, phone, bio, and specialties can be updated', function () {
    $coach = User::factory()->create([
        'name' => 'Coach',
        'email' => 'coach@themoneycircle.com',
    ]);

    $response = $this
        ->actingAs($coach)
        ->patch('/profile', [
            'name' => 'Expert Coach',
            'email' => 'coach@themoneycircle.com',
            'title' => 'Lead Wealth & Debt Elimination Coach',
            'phone' => '+254712345678',
            'bio' => 'Empowering members to eliminate toxic debt and achieve financial peace.',
            'specialties' => 'Debt Snowball, High-Yield MMFs, Real Estate Planning',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $coach->refresh();

    expect($coach->name)->toBe('Expert Coach')
        ->and($coach->title)->toBe('Lead Wealth & Debt Elimination Coach')
        ->and($coach->phone)->toBe('+254712345678')
        ->and($coach->bio)->toBe('Empowering members to eliminate toxic debt and achieve financial peace.')
        ->and($coach->specialties)->toBe('Debt Snowball, High-Yield MMFs, Real Estate Planning');

    $viewResponse = $this->actingAs($coach)->get('/profile');
    $viewResponse->assertOk();
    $viewResponse->assertSee('Expert Coach');
    $viewResponse->assertSee('Lead Wealth & Debt Elimination Coach');
    $viewResponse->assertSee('+254712345678');
    $viewResponse->assertSee('VERIFIED COACH');
});

