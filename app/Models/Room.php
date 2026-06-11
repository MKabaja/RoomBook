<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['name', 'capacity'];

    /** @return HasMany<Booking, $this> */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
        ];
    }
}
