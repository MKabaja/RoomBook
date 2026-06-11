<?php

declare(strict_types=1);

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('authenticated user can list rooms', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    Room::factory()->count(3)->create();

    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/rooms');

    $response->assertOk()
        ->assertJsonCount(3);
});

test('rooms returns 401 without token', function () {
    /** @var TestCase $this */
    $response = $this->getJson('/api/rooms');
    $response->assertUnauthorized();

});
