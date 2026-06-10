<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

describe('registration', function () {

    $validData = [
        'name' => 'Jan Kowalski',
        'email' => 'jan@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $invalidEmailData = [
        'name' => 'Jan Kowalski',
        'email' => '',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    test('user can register with valid data', function () use ($validData) {
        /** @var TestCase $this */
        $response = $this->postJson('/api/register', $validData);

        $response->assertCreated()
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]);

    });
    test('register fails with missing email', function () use ($invalidEmailData) {
        /** @var TestCase $this */
        $response = $this->postJson('/api/register', $invalidEmailData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('register fails with duplicate email', function () use ($validData) {
        /** @var TestCase $this */
        User::factory()->create(['email' => $validData['email']]);

        $response = $this->postJson('/api/register', $validData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });
});

describe('login', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test')->plainTextToken;
    });

    test('user can login with correct password', function () {
        /** @var TestCase $this */
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $response->assertOk()
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ])
            ->assertJson([
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],
            ]);
    });

    test('login fails with wrong password', function () {
        /** @var TestCase $this */
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials',
            ]);
    });

    test('user can logout', function () {
        /** @var TestCase $this */
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/logout');

        $response->assertNoContent();

    });

});

test('protected route returns 401 without token', function () {
    /** @var TestCase $this */
    $response = $this->postJson('/api/logout');

    $response->assertUnauthorized();

});
