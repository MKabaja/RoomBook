<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Booking\BookingValidationPipeline;
use App\Services\Booking\Validators\AvailabilityValidator;
use App\Services\Booking\Validators\DateOrderValidator;
use App\Services\Booking\Validators\FutureDateValidator;
use App\Services\Booking\Validators\RoomCapacityValidator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BookingValidationPipeline::class, function ($app) {
            return new BookingValidationPipeline([
                new DateOrderValidator,
                new FutureDateValidator,
                new RoomCapacityValidator,
                new AvailabilityValidator,
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
