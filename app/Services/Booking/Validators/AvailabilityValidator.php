<?php

declare(strict_types=1);

namespace App\Services\Booking\Validators;

use App\DataTransferObjects\BookingData;
use App\Models\Booking;
use App\Services\Booking\Contracts\BookingValidatorInterface;
use Illuminate\Validation\ValidationException;

final class AvailabilityValidator implements BookingValidatorInterface
{
    public function validate(BookingData $data): void
    {
        if ($this->hasConflict($data)) {
            throw ValidationException::withMessages([
                'starts_at' => 'This reservation overlaps with an existing booking.',
            ]);
        }
    }

    private function hasConflict(BookingData $data): bool
    {
        return Booking::where('room_id', $data->roomId)
            ->active()
            ->overlapping($data->startsAt, $data->endsAt)
            ->lockForUpdate()
            ->exists();
    }
}
