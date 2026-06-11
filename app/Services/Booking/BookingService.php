<?php

declare(strict_types=1);

namespace App\Services\Booking;

use App\DataTransferObjects\BookingData;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

final class BookingService
{
    public function __construct(private BookingValidationPipeline $validationPipeline) {}

    public function store(BookingData $data): Booking
    {
        $this->validationPipeline->validate($data);

        $booking = Booking::create([
            'room_id' => $data->roomId,
            'user_id' => $data->userId,
            'starts_at' => $data->startsAt,
            'ends_at' => $data->endsAt,
            'participants_count' => $data->participantsCount,
            'status' => BookingStatus::Pending,
        ]);

        return $booking->load('room');

    }

    public function cancel(Booking $booking): Booking
    {
        if ($booking->status === BookingStatus::Cancelled) {
            throw ValidationException::withMessages(['status' => 'Booking is already cancelled.']);
        }
        $booking->update(['status' => BookingStatus::Cancelled]);

        return $booking;
    }

    /**
     * @return LengthAwarePaginator<int,Booking>
     */
    public function getForUser(User $user): LengthAwarePaginator
    {
        return $user->bookings()->with('room')->latest()->paginate(15);
    }
}
