<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        if ($admin->role !== 'admin') {
            abort(403);
        }

        $stats = [
            'schools' => \App\Models\School::count(),
            'classes' => \App\Models\SchoolClass::count(),
            'teachers' => \App\Models\User::where('role', 'teacher')->count(),
            'students' => \App\Models\User::where('role', 'student')->count(),
            'modules' => \App\Models\Module::count(),
        ];

        $leaderboard = \App\Models\User::where('role', 'student')
                        ->with('class.school')
                        ->orderBy('points', 'desc')
                        ->limit(5)
                        ->get();

        $latestJournals = \App\Models\Journal::with(['user', 'module'])
                            ->latest()
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact('admin', 'stats', 'leaderboard', 'latestJournals'));
    }
}
