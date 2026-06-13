<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->user = User::factory()->create();
    $this->actingAs($this->user, 'sanctum');
});

test('user can cancel own booking', function () {
    /** @var TestCase $this */
    $booking = Booking::factory()->forUser($this->user)->create();

    $response = $this->patchJson("/api/bookings/{$booking->id}/cancel");

    expect($response->status())->toBe(200);
    expect($response->json('status'))->toBe('cancelled');

});

test('user cannot cancel others booking', function () {
    /** @var TestCase $this */
    $secondUser = User::factory()->create();
    $booking = Booking::factory()->forUser($secondUser)->create();

    $response = $this->patchJson("/api/bookings/{$booking->id}/cancel");

    expect($response->status())->toBe(403);

});

test('cannot cancel already cancelled booking', function () {
    /** @var TestCase $this */
    $canceledBooking = Booking::factory()->forUser($this->user)->cancelled()->create();

    $response = $this->patchJson("/api/bookings/{$canceledBooking->id}/cancel");

    expect($response->status())->toBe(422);
    expect($response->json('errors.status'))->not->toBeEmpty();

});
