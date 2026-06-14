<?php

declare(strict_types=1);

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can list rooms', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    Room::factory()->count(3)->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/rooms');

    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveCount(3);
});

test('rooms returns 401 without token', function () {
    /** @var TestCase $this */
    $response = $this->getJson('/api/rooms');

    expect($response->status())->toBe(401);
});
