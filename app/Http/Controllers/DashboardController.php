<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function showImages()
    {
        return Inertia::render('Images');
    }

    public function showLogs()
    {
        $logs = Log::all()->take(10);
        return Inertia::render('ScheduleLogs', ['logs' => $logs]);
    }
}
