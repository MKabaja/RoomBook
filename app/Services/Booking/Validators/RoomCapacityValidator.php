<?php

declare(strict_types=1);

namespace App\Services\Booking\Validators;

use App\DataTransferObjects\BookingData;
use App\Models\Room;
use App\Services\Booking\Contracts\BookingValidatorInterface;
use Illuminate\Validation\ValidationException;

final class RoomCapacityValidator implements BookingValidatorInterface
{
    public function validate(BookingData $data): void
    {
        if ($this->hasConflict($data)) {

            throw ValidationException::withMessages([
                'participants_count' => 'Room capacity exceeded',
            ]);
        }
    }

    private function hasConflict(BookingData $data): bool
    {

        return Room::where('id', $data->roomId)
            ->where('capacity', '<', $data->participantsCount)
            ->exists();
    }
}
