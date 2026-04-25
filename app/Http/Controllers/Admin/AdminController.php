<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Photo;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers     = User::where('role', 'user')->count();
        $totalPhotos    = Photo::count();
        $todayPhotos    = Photo::whereDate('created_at', today())->count();
        $todayLogins    = ActivityLog::where('action', 'login')->whereDate('created_at', today())->count();
        $recentPhotos   = Photo::with('user')->latest()->take(8)->get();
        $recentActivity = ActivityLog::with('user')->latest()->take(10)->get();
        $topUploaders   = User::withCount('photos')->orderByDesc('photos_count')->take(5)->get();

        // Monthly upload stats (last 7 days)
        $uploadStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $uploadStats[] = [
                'date'  => $date->format('d M'),
                'count' => Photo::whereDate('created_at', $date->toDateString())->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalPhotos', 'todayPhotos', 'todayLogins',
            'recentPhotos', 'recentActivity', 'topUploaders', 'uploadStats'
        ));
    }
}
