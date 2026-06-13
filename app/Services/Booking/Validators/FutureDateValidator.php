<?php

declare(strict_types=1);

namespace App\Services\Booking\Validators;

use App\DataTransferObjects\BookingData;
use App\Services\Booking\Contracts\BookingValidatorInterface;
use Illuminate\Validation\ValidationException;

final class FutureDateValidator implements BookingValidatorInterface
{
    public function validate(BookingData $data): void
    {
        if ($this->hasConflict($data)) {
            throw ValidationException::withMessages([
                'starts_at' => 'The start time cannot be in the past.',
            ]);
        }
    }

    private function hasConflict(BookingData $data): bool
    {

        return $data->startsAt->isPast();
    }
}
