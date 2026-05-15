<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\PointsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Get activity stats
        $totalPoints = $user->points;
        $totalModules = Module::where('is_active', true)->count();
        $completedModules = $user->progress()->where('is_completed', true)->count();
        
        // Get earned badges from completed modules
        $earnedBadges = Module::whereIn('id', function($query) use ($user) {
            $query->select('module_id')->from('module_progress')
                  ->where('user_id', $user->id)
                  ->where('is_completed', true);
        })->get(['badge_name', 'badge_icon']);

        // Calculate rank within class
        $rank = \App\Models\User::where('class_id', $user->class_id)
            ->where('role', 'student')
            ->where('points', '>', $user->points)
            ->count() + 1;

        // Get points logs
        $logs = PointsLog::where('user_id', $user->id)->latest()->take(10)->get();

        return view('student.profile.show', compact('user', 'totalPoints', 'totalModules', 'completedModules', 'logs', 'earnedBadges', 'rank'));
    }
}
