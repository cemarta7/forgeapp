<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Inertia\Inertia;

class JobStatusController extends Controller
{
    public function index()
    {
        $stats = $this->getQueueStats();
        
        return Inertia::render('JobStatus', [
            'stats' => $stats,
        ]);
    }

    public function stats()
    {
        return response()->json($this->getQueueStats());
    }

    public function dispatch(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:100',
        ]);

        $count = $request->input('count');

        for ($i = 0; $i < $count; $i++) {
            TestJob::dispatch();
        }

        return response()->json([
            'message' => "{$count} job(s) dispatched successfully",
            'stats' => $this->getQueueStats(),
        ]);
    }

    private function getQueueStats(): array
    {
        $driver = config('queue.default');
        
        $pendingCount = 0;
        $failedCount = 0;

        if ($driver === 'database') {
            $pendingCount = DB::table('jobs')->count();
            $failedCount = DB::table('failed_jobs')->count();
        } elseif ($driver === 'redis') {
            $queueName = config('queue.connections.redis.queue', 'default');
            $connection = config('queue.connections.redis.connection', 'default');
            $pendingCount = Queue::size($queueName);
            $failedCount = DB::table('failed_jobs')->count();
        }

        return [
            'driver' => $driver,
            'pending' => $pendingCount,
            'failed' => $failedCount,
        ];
    }
}
