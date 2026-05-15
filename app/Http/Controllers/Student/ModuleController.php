<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleProgress;
use App\Models\PointsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    protected $steps = [
        'P' => 'Pelajari',
        'E' => 'Eksplorasi',
        'D' => 'Diskusi',
        'U' => 'Ungkapkan',
        'L' => 'Lakukan',
        'I' => 'Introspeksi',
    ];

    protected $stepSequence = ['P', 'E', 'D', 'U', 'L', 'I'];

    public function nextStep(Request $request, Module $module, $currentStepKey)
    {
        $user = Auth::user();
        $progress = ModuleProgress::where('user_id', $user->id)->where('module_id', $module->id)->first();

        if (!$progress) return back();

        // Save Journal if any content or emotion is provided
        if ($request->filled('content') || $request->filled('emotion') || $request->hasFile('image')) {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('journals', 'public');
                $imagePath = '/storage/' . $path;
            }

            \App\Models\Journal::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'step' => $currentStepKey,
                'content' => $request->input('content', ''),
                'emotion_emoji' => $request->input('emotion'),
                'image' => $imagePath,
                'is_private' => false,
            ]);
        }

        // Find next step in sequence
        $currentIndex = array_search($currentStepKey, $this->stepSequence);
        $nextIndex = $currentIndex + 1;

        if ($nextIndex < count($this->stepSequence)) {
            $nextStepKey = $this->stepSequence[$nextIndex];
            $progress->update(['current_step' => $nextStepKey]);

            // Reward Points
            $points = 20;
            $user->increment('points', $points);
            PointsLog::create([
                'user_id' => $user->id,
                'points' => $points,
                'activity_type' => "Selesai Fase " . ($this->steps[$currentStepKey] ?? $currentStepKey),
            ]);

            return redirect()->route('student.module.step', [$module->id, $nextStepKey])
                             ->with('success', 'Hebat! Kamu dapat ' . $points . ' poin.');
        } else {
            // Module completed
            $progress->update(['is_completed' => true]);
            return redirect()->route('student.dashboard')->with('success', 'Selamat! Kamu telah menyelesaikan modul ini.');
        }
    }

    public function show(Module $module)
    {
        $user = Auth::user();
        
        // Find or create progress
        $progress = ModuleProgress::firstOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['current_step' => 'P', 'is_completed' => false]
        );

        return redirect()->route('student.module.step', [$module->id, $progress->current_step]);
    }

    public function showStep(Module $module, $step)
    {
        $user = Auth::user();
        $progress = ModuleProgress::where('user_id', $user->id)->where('module_id', $module->id)->first();

        if (!$progress) {
            return redirect()->route('student.module.show', $module->id);
        }

        // Enforce sequence: don't allow skipping ahead
        $requestedIndex = array_search($step, $this->stepSequence);
        $currentIndex = array_search($progress->current_step, $this->stepSequence);

        if ($requestedIndex > $currentIndex && !$progress->is_completed) {
            // Redirect to their actual current step
            return redirect()->route('student.module.step', [$module->id, $progress->current_step]);
        }

        // Mapping step keys to names
        $stepName = $this->steps[$step] ?? 'Pelajari';

        $messages = [];
        if ($step === 'D') {
            $query = \App\Models\Message::where('module_id', $module->id)
                ->where('class_id', $user->class_id);
            
            if ($user->group_id) {
                $query->where('group_id', $user->group_id);
            } else {
                $query->whereNull('group_id');
            }

            $messages = $query->with('user')
                ->oldest()
                ->get();
        }
        
        return view("student.steps." . strtolower($stepName), compact('module', 'progress', 'step', 'messages'));
    }
}
