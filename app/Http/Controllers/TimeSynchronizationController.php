<?php

namespace App\Http\Controllers;

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
     * @param         $timestamp
     *
     * @return JsonResponse
     */
    public function sync($timestamp): JsonResponse
    {
        $dateTime = Carbon::createFromTimestamp($timestamp);
        $marsClock = new MarsClock($dateTime);
        return response()->json([
            "mars_sol_date" => $marsClock->getMsd(),
            "martian_coordinated_time" => $marsClock->getMtc()
        ]);
    }
}
