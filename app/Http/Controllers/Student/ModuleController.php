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
        'S' => 'Soal_Essay',
    ];

    protected $stepSequence = ['P', 'E', 'D', 'U', 'L', 'I', 'S'];

    public function nextStep(Request $request, Module $module, $currentStepKey)
    {
        $user = Auth::user();
        $progress = ModuleProgress::where('user_id', $user->id)->where('module_id', $module->id)->first();

        if (!$progress) return back();

        // Validation
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'reflection' => 'nullable|string',
            'emotion' => 'nullable|string',
            'essay_emotional' => 'nullable|string',
            'essay_perspective' => 'nullable|string',
            'essay_care' => 'nullable|string',
            'essay_responsibility' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('journals', 'public');
            $imagePath = '/storage/' . $path;
        }

        // Create/Update Journal for every phase completion
        $defaultContents = [
            'P' => 'Siswa telah mempelajari materi.',
            'E' => 'Siswa telah mengeksplorasi perspektif.',
            'D' => 'Siswa telah berpartisipasi dalam diskusi.',
        ];

        $content = $request->input('content', $request->input('reflection', ''));
        
        // Handle Multiple Essays for step 'S'
        if ($currentStepKey === 'S') {
            $essays = [
                'emotional' => $request->input('essay_emotional'),
                'perspective' => $request->input('essay_perspective'),
                'care' => $request->input('essay_care'),
                'responsibility' => $request->input('essay_responsibility'),
            ];
            $content = json_encode($essays);
        }

        if (empty($content) && isset($defaultContents[$currentStepKey])) {
            $content = $defaultContents[$currentStepKey];
        }

        \App\Models\Journal::updateOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id, 'step' => $currentStepKey],
            [
                'content' => $content,
                'emotion_emoji' => $request->input('emotion'),
                'image' => $imagePath ?? (\App\Models\Journal::where('user_id', $user->id)->where('module_id', $module->id)->where('step', $currentStepKey)->first()?->image),
                'is_private' => false,
            ]
        );

        // Notify Teacher
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'module_id' => $module->id,
            'step' => $currentStepKey,
            'type' => 'step_completed',
            'title' => 'Input Jurnal Baru',
            'message' => $user->name . ' telah menyelesaikan fase ' . ($this->steps[$currentStepKey] ?? $currentStepKey) . ' di modul ' . $module->title,
            'target_class_id' => $user->class_id,
        ]);

        // Find next step in sequence
        $currentIndex = array_search($currentStepKey, $this->stepSequence);
        $nextIndex = $currentIndex + 1;

        if ($nextIndex < count($this->stepSequence)) {
            $nextStepKey = $this->stepSequence[$nextIndex];
            $progress->update(['current_step' => $nextStepKey]);

            return redirect()->route('student.module.step', [$module->id, $nextStepKey])
                             ->with('success', 'Fase ' . ($this->steps[$currentStepKey] ?? $currentStepKey) . ' selesai. Menunggu penilaian guru.');
        } else {
            // Module completed
            $progress->update(['is_completed' => true]);

            // Award Points for Completion
            $completionPoints = 50;
            $user->increment('points', $completionPoints);
            \App\Models\PointsLog::create([
                'user_id' => $user->id,
                'points' => $completionPoints,
                'activity_type' => 'Penyelesaian Modul: ' . $module->title
            ]);

            // Notify Teacher about module completion
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'type' => 'module_completed',
                'title' => 'Modul Selesai',
                'message' => $user->name . ' telah menyelesaikan seluruh materi di modul ' . $module->title,
                'target_class_id' => $user->class_id,
            ]);

            // Notify Student about Badge
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'type' => 'badge_earned',
                'title' => 'Lencana Baru!',
                'message' => 'Selamat! Kamu mendapatkan lencana "' . $module->badge_name . '" karena telah menyelesaikan modul ' . $module->title,
            ]);

            return redirect()->route('student.dashboard')->with('success', 'Selamat! Kamu telah menyelesaikan modul ini dan mendapatkan lencana ' . $module->badge_name);
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
        $groupMap = null;

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
            
            if ($user->group_id) {
                $groupMap = \App\Models\GroupMap::where('group_id', $user->group_id)
                    ->where('module_id', $module->id)
                    ->first();
            }
        }
        
        return view("student.steps." . strtolower($stepName), compact('module', 'progress', 'step', 'messages', 'groupMap'));
    }
}
