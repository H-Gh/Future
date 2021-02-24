<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSynchronizationRequest;
use App\Services\MarsClock;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * Class TImeCalculationController
 *
 * @package App\Http\Controllers
 */
class TimeSynchronizationController extends Controller
{
    /**
     * @param                            $timestamp
     * @param TimeSynchronizationRequest $request
     *
     * @return JsonResponse
     */
    public function sync($timestamp, TimeSynchronizationRequest $request): JsonResponse
    {
        $dateTime = Carbon::createFromTimestamp($timestamp);
        $marsClock = new MarsClock($dateTime);
        return response()->json([
            "mars_sol_date" => $marsClock->getMsd(),
            "martian_coordinated_time" => $marsClock->getMtc()
        ]);
    }
}
