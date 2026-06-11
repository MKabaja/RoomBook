<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Sala Konferencyjna', 'Sala Spotkań', 'Sala Szkoleniowa']).' '.fake()->randomLetter(),
            'capacity' => fake()->randomElement([6, 8, 10, 12, 20, 30]),
        ];
    }
}
