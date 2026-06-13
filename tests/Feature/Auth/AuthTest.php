<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function validRegistrationPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Jan Kowalski',
        'email' => 'jan@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ], $overrides);
}

beforeEach(function () {
    /** @var TestCase $this */
    $this->user = User::factory()->create();
});

test('user can register with valid data', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/register', validRegistrationPayload());

    expect($response->status())->toBe(201)
        ->and($response->json('token'))->not->toBeNull()
        ->and($response->json('user.email'))->toBe('jan@example.com');
});

test('register fails with missing email', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/register', validRegistrationPayload(['email' => '']));

    expect($response->status())->toBe(422)
        ->and($response->json('errors.email'))->not->toBeEmpty();
});

test('register fails with duplicate email', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/register', validRegistrationPayload(['email' => $this->user->email]));

    expect($response->status())->toBe(422)
        ->and($response->json('errors.email'))->not->toBeEmpty();
});

test('user can login with correct password', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);

    expect($response->status())->toBe(200)
        ->and($response->json('token'))->not->toBeNull()
        ->and($response->json('user.id'))->toBe($this->user->id);
});

test('login fails with wrong password', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => 'wrongpassword',
    ]);

    expect($response->status())->toBe(401)
        ->and($response->json('message'))->toBe('Invalid credentials');
});

test('user can logout', function () {
    /** @var TestCase $this */
    $token = $this->user->createToken('test')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/logout');

    expect($response->status())->toBe(204);
});

test('protected route returns 401 without token', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/logout');

    expect($response->status())->toBe(401);
});
