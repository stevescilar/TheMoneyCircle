<?php

test('landing page loads successfully and contains app download links without exposing coach links or Coach Steve', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('The Money Circle');
    $response->assertSee('/downloads/TheMoneyCircle.apk');
    $response->assertDontSee('Coach Portal');
    $response->assertDontSee('Coach & Admin Login');
    $response->assertDontSee('Coach Steve');
});

test('download shortcut route redirects to download section', function () {
    $response = $this->get('/download');

    $response->assertRedirect('/#download');
});

test('apk download route serves android package with proper headers', function () {
    $response = $this->get('/downloads/TheMoneyCircle.apk');

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/vnd.android.package-archive');
});

test('legacy lowercase apk download route redirects to primary download route', function () {
    $response = $this->get('/downloads/the-money-circle.apk');

    $response->assertRedirect(route('download.apk'));
});
