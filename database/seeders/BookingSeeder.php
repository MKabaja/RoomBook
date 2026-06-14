<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $roomA = Room::where('name', 'Sala Konferencyjna A')->firstOrFail();
        $roomB = Room::where('name', 'Sala Spotkań B')->firstOrFail();
        $roomC = Room::where('name', 'Sala Szkoleniowa C')->firstOrFail();
        $roomD = Room::where('name', 'Sala Zarządu D')->firstOrFail();

        Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $roomA->id,
            'starts_at' => Carbon::tomorrow()->setTime(9, 0),
            'ends_at' => Carbon::tomorrow()->setTime(11, 0),
            'participants_count' => 5,
        ]);

        Booking::factory()->confirmed()->create([
            'user_id' => $user->id,
            'room_id' => $roomB->id,
            'starts_at' => Carbon::tomorrow()->setTime(14, 0),
            'ends_at' => Carbon::tomorrow()->setTime(16, 0),
            'participants_count' => 4,
        ]);

        Booking::factory()->cancelled()->create([
            'user_id' => $user->id,
            'room_id' => $roomC->id,
            'starts_at' => Carbon::now()->addDays(2)->setTime(10, 0),
            'ends_at' => Carbon::now()->addDays(2)->setTime(12, 0),
            'participants_count' => 20,
        ]);

        Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $roomD->id,
            'starts_at' => Carbon::now()->addDays(3)->setTime(13, 0),
            'ends_at' => Carbon::now()->addDays(3)->setTime(15, 0),
            'participants_count' => 7,
        ]);
    }
}
