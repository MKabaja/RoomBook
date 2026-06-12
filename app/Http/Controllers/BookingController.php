<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\BookingData;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request): JsonResponse
    {
        $createdBookings = $this->bookingService->getForUser($request->user());

        return response()->json($createdBookings);
    }

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $bookingData = BookingData::fromRequest($request, $request->user()->id);
        $booking = $this->bookingService->store($bookingData);

        return response()->json($booking);
    }

    public function cancel(Booking $booking): JsonResponse
    {
        $this->authorize('cancel', $booking);
        $booking = $this->bookingService->cancel($booking);

        return response()->json($booking);

    }
}
