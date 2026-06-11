<?php

declare(strict_types=1);

namespace App\Services\Booking\Validators;

use App\DataTransferObjects\BookingData;
use App\Services\Booking\Contracts\BookingValidatorInterface;
use Illuminate\Validation\ValidationException;

final class DateOrderValidator implements BookingValidatorInterface
{
    public function validate(BookingData $data): void
    {
        if ($this->hasConflict($data)) {
            throw ValidationException::withMessages([
                'ends_at' => 'The end time must be after the start time.',
            ]);
        }
    }

    private function hasConflict(BookingData $data): bool
    {
        return $data->endsAt->isBefore($data->startsAt);
    }
}
