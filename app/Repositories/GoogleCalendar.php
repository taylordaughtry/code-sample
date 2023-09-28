<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use App\Interfaces\EventRepositoryInterface;

class GoogleCalendar implements EventRepositoryInterface
{
    /**
     * Resolve available times for the given User via Google Calendar.
     *
     * @param int $id
     * @return Collection<Carbon>
     */
    public function byUserId(int $id): Collection
    {
        // In the real-world, this would be fetching live data for the given
        // User. Since I'm simply stubbing this out to demonstrate substitution
        // via service container in tests, I've omitted this for the sake of time.

        return collect([
            CarbonImmutable::now()->addHours(2),
            CarbonImmutable::now()->addHours(5),
            CarbonImmutable::now()->addHours(6),
        ]);
    }
}