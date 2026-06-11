<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::create(['name' => 'Sala Konferencyjna A', 'capacity' => 12]);
        Room::create(['name' => 'Sala Spotkań B', 'capacity' => 6]);
        Room::create(['name' => 'Sala Szkoleniowa C', 'capacity' => 30]);
        Room::create(['name' => 'Sala Zarządu D', 'capacity' => 8]);
        Room::create(['name' => 'Sala Kreatywna E', 'capacity' => 15]);
    }
}
