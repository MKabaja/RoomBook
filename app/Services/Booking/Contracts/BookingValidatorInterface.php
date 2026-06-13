<?php

declare(strict_types=1);

namespace App\Services\Booking\Contracts;

use App\DataTransferObjects\BookingData;
use Illuminate\Validation\ValidationException;

interface BookingValidatorInterface
{
    /** @throws ValidationException */
    public function validate(BookingData $data): void;
}
