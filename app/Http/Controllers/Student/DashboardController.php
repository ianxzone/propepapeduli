<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $modules = Module::where('is_active', true)->get()->map(function($module) use ($user) {
            $progress = $module->progress()->where('user_id', $user->id)->first();
            
            // Map step to index (1-6)
            $stepMap = ['P' => 1, 'E' => 2, 'D' => 3, 'U' => 4, 'L' => 5, 'I' => 6];
            $module->current_step_index = $progress ? $stepMap[$progress->current_step] : 0;
            $module->is_completed = $progress ? $progress->is_completed : false;
            
            return $module;
        });

        $completedModules = $modules->filter->is_completed;
        $totalPoints = $user->points;
        
        return view('student.dashboard', compact('user', 'modules', 'completedModules', 'totalPoints'));
    }

    public function leaderboard()
    {
        $user = Auth::user();
        
        // Get top 10 students globally
        $topStudents = \App\Models\User::where('role', 'student')
            ->with('class')
            ->orderBy('points', 'desc')
            ->limit(10)
            ->get();
            
        // Find current user's rank
        $rank = \App\Models\User::where('role', 'student')
            ->where('points', '>', $user->points)
            ->count() + 1;

        return view('student.leaderboard', compact('user', 'topStudents', 'rank'));
    }
}
