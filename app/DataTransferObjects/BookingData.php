<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Http\Requests\StoreBookingRequest;
use Illuminate\Support\Carbon;

final readonly class BookingData
{
    public function __construct(
        public int $roomId,
        public int $userId,
        public Carbon $startsAt,
        public Carbon $endsAt,
        public int $participantsCount,
    ) {}

    public static function fromRequest(StoreBookingRequest $request, int $userId): self
    {
        return new self(
            roomId: (int) $request->validated('room_id'),
            userId: $userId,
            startsAt: Carbon::parse($request->validated('starts_at')),
            endsAt: Carbon::parse($request->validated('ends_at')),
            participantsCount: (int) $request->validated('participants_count'),
        );
    }
}
