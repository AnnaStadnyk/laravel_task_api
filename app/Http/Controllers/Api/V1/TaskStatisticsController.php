<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskStatisticsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $count_task = Auth::user()->tasks()->count();

        $count_task_by_param = Auth::user()->tasks()
            ->select(['priority', 'is_comleted', DB::raw('COUNT(priority) as count')])
            ->groupBy('priority', 'is_comleted')->get();

        $count_task_expires = Auth::user()->tasks()
            ->select(['priority', DB::raw('COUNT(priority) as count')])
            ->where('is_comleted', false)
            ->where('control_at', '<=', today()->addDays(3))
            ->groupBy('priority')->get();

        return response()->json([
            'count_task' => $count_task,
            'count_task_by_param' => $count_task_by_param,
            'count_task_expires' => $count_task_expires
        ]);
    }
}
