<?php

// Registration is disabled for now (see routes/auth.php) — single-user
// site, only the owner logs in. Skipped rather than deleted so these are
// ready to re-enable if public registration ever comes back.

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip('Registration route is disabled');

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
})->skip('Registration route is disabled');
