<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use App\Http\Resources\AvailabilityCollection;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, Request $request)
    {
        $startDate = CarbonImmutable::parse($request->query('startDate'))->setTimezone('UTC')->startOfHour();

        $endDate = CarbonImmutable::parse($request->query('endDate') ?? '+1 days')->setTimezone('UTC')->startOfHour();

        $period = CarbonPeriod::create($startDate, '1 hours', $endDate);

        $availability = $user->availability($period);
        return $availability;
        // return new AvailabilityCollection($availability);
    }
}
