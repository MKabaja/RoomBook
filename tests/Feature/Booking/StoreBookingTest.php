<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

uses(RefreshDatabase::class);

function validBookingPayload(Room $room, array $overrides = []): array
{
    return array_merge([
        'room_id' => $room->id,
        'starts_at' => Carbon::tomorrow()->setTime(10, 0)->toISOString(),
        'ends_at' => Carbon::tomorrow()->setTime(12, 0)->toISOString(),
        'participants_count' => 3,
    ], $overrides);
}

beforeEach(function () {
    /** @var TestCase $this */
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'sanctum');
});

test('user can create booking', function () {
    /** @var TestCase $this */
    $room = Room::factory()->create();

    $payload = validBookingPayload($room);

    $response = $this->postJson('/api/bookings', $payload);

    expect($response->status())->toBe(201);
    expect($response->json('status'))->toBe('pending');

});

test('booking fails when ends before starts', function () {
    /** @var TestCase $this */
    $room = Room::factory()->create();

    $payload = validBookingPayload($room, ['ends_at' => Carbon::tomorrow()->setTime(8, 0)->toISOString()]);

    $response = $this->postJson('/api/bookings', $payload);

    expect($response->status())->toBe(422);
    expect($response->json('errors.ends_at'))->not->toBeEmpty();
});

test('booking fails when participants exceed capacity', function () {
    /** @var TestCase $this */
    $room = Room::factory()->create(['capacity' => 5]);

    $payload = validBookingPayload($room, ['participants_count' => 6]);

    $response = $this->postJson('/api/bookings', $payload);

    expect($response->status())->toBe(422);
    expect($response->json('errors.participants_count'))->not->toBeEmpty();
});

test('booking fails when time conflicts with existing booking', function () {
    /** @var TestCase $this */
    $room = Room::factory()->create();
    $start = Carbon::tomorrow()->setTime(10, 0);

    Booking::factory()->forRoom($room)->startingAt($start)->create();

    $payload = validBookingPayload($room, [
        'starts_at' => $start->toISOString(),
        'ends_at' => $start->copy()->addHours(2)->toISOString(),
    ]);

    $response = $this->postJson('/api/bookings', $payload);

    expect($response->status())->toBe(422);
    expect($response->json('errors.starts_at'))->not->toBeEmpty();
});

test('booking fails for past date', function () {
    /** @var TestCase $this */
    $room = Room::factory()->create();

    $payload = validBookingPayload($room, ['starts_at' => Carbon::yesterday()->toISOString()]);

    $response = $this->postJson('/api/bookings', $payload);

    expect($response->status())->toBe(422);
    expect($response->json('errors.starts_at'))->not->toBeEmpty();
});

test('cancelled booking does not block slot', function () {
    /** @var TestCase $this */
    $room = Room::factory()->create();
    $start = Carbon::tomorrow()->setTime(10, 0);

    Booking::factory()->forRoom($room)->startingAt($start)->cancelled()->create();

    $payload = validBookingPayload($room, [
        'starts_at' => $start->toISOString(),
        'ends_at' => $start->copy()->addHours(2)->toISOString(),
    ]);

    $response = $this->postJson('/api/bookings', $payload);

    expect($response->status())->toBe(201);

});
