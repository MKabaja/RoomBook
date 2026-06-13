<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'starts_at' => fake()->dateTimeBetween('+1 day', '+7 days'),
            'ends_at' => fn (array $attrs) => Carbon::parse($attrs['starts_at'])->addHours(2),
            'participants_count' => fake()->numberBetween(1, 10),
            'status' => BookingStatus::Pending,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(['status' => BookingStatus::Confirmed]);
    }

    public function cancelled(): static
    {
        return $this->state(['status' => BookingStatus::Cancelled]);
    }

    public function forRoom(Room $room): static
    {
        return $this->state([
            'room_id' => $room->id,
            'participants_count' => fake()->numberBetween(1, $room->capacity),
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state(['user_id' => $user->id]);
    }

    public function startingAt(Carbon $start, int $durationHours = 2): static
    {
        return $this->state([
            'starts_at' => $start,
            'ends_at' => $start->copy()->addHours($durationHours),
        ]);
    }
}
