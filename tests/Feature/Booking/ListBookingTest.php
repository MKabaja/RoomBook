<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('booking endpoints return 401 without token', function () {
    /** @var TestCase $this */
    expect($this->getJson('/api/bookings')->status())->toBe(401);
    expect($this->postJson('/api/bookings', [])->status())->toBe(401);
});

test('user sees only own bookings', function () {
    /** @var TestCase $this */
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'sanctum');

    Booking::factory()->count(2)->forUser($this->user)->create();
    Booking::factory()->create();

    $response = $this->getJson('/api/bookings/');

    expect($response->status())->toBe(200);
    expect($response->json('data'))->toHaveCount(2);
});
