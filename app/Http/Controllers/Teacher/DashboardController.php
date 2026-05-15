<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\Module;
use App\Models\Journal;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user();
        
        // Ensure only teachers or admins access this
        if (!in_array($teacher->role, ['teacher', 'admin'])) {
            return redirect()->route('student.dashboard');
        }

        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && $teacher->role === 'admin') {
            $classId = SchoolClass::first()?->id;
        }

        $class = SchoolClass::with('school')->find($classId);
        $classes = SchoolClass::all();
        
        if (!$class) {
            return redirect()->route('login')->with('error', 'Kelas tidak ditemukan.');
        }
        
        // Get all active modules
        $modules = Module::where('is_active', true)->get();
        
        // Get all students in this class
        $students = User::where('role', 'student')
                        ->where('class_id', $classId)
                        ->orderBy('name')
                        ->get();

        // Calculate class average progress
        $totalStudents = $students->count();
        $totalPoints = $students->sum('points');
        $averagePoints = $totalStudents > 0 ? round($totalPoints / $totalStudents) : 0;

        // Stats for Chart: Completion per phase across the class
        $phaseStats = [
            'P' => 0, 'E' => 0, 'D' => 0, 'U' => 0, 'L' => 0, 'I' => 0
        ];

        foreach ($students as $student) {
            $progresses = $student->progress;
            foreach ($progresses as $prog) {
                // We count how many students have reached/passed each phase
                $phases = ['P', 'E', 'D', 'U', 'L', 'I'];
                $currentIndex = array_search($prog->current_step, $phases);
                for ($i = 0; $i <= $currentIndex; $i++) {
                    $phaseStats[$phases[$i]]++;
                }
            }
        }

        return view('teacher.dashboard', compact('teacher', 'class', 'classes', 'students', 'modules', 'averagePoints', 'totalStudents', 'phaseStats'));
    }

    public function journals(Request $request)
    {
        $teacher = Auth::user();
        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && $teacher->role === 'admin') $classId = SchoolClass::first()?->id;

        $class = SchoolClass::find($classId);
        $classes = SchoolClass::all();
        
        // Get all journals from students in this class
        $journals = Journal::whereIn('user_id', function($query) use ($classId) {
            $query->select('id')->from('users')->where('class_id', $classId);
        })->with(['user', 'module'])->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.journals.index', compact('journals', 'class', 'classes'));
    }

    public function studentDetail(User $student)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin']) || ($teacher->role === 'teacher' && $student->class_id !== $teacher->class_id)) {
            abort(403);
        }

        $modules = Module::where('is_active', true)->get();
        $journals = $student->journals()->with('module')->orderBy('created_at', 'desc')->get();
        
        return view('teacher.student-detail', compact('student', 'modules', 'journals'));
    }

    public function saveFeedback(Request $request, Journal $journal)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin'])) abort(403);

        $request->validate([
            'teacher_feedback' => 'nullable|string',
            'teacher_points' => 'required|integer|min:0|max:100',
        ]);

        $oldPoints = $journal->teacher_points;

        $journal->update([
            'teacher_feedback' => $request->teacher_feedback,
            'teacher_points' => $request->teacher_points,
        ]);

        // Update student total points based on difference
        $diff = $request->teacher_points - $oldPoints;
        if ($diff != 0) {
            $journal->user->increment('points', $diff);
            \App\Models\PointsLog::create([
                'user_id' => $journal->user->id,
                'points' => $diff,
                'activity_type' => "Penilaian Fase " . $journal->step . " (" . $journal->module->title . ")",
            ]);
        }

        return back()->with('success', 'Umpan balik dan nilai berhasil disimpan.');
    }

    public function forum(Request $request)
    {
        $user = Auth::user();
        $classId = $request->input('class_id', $user->class_id);
        if (!$classId && $user->role === 'admin') $classId = SchoolClass::first()?->id;
        
        $class = SchoolClass::find($classId);
        $classes = SchoolClass::all();
        $modules = Module::where('is_active', true)->get();
        $groups = StudentGroup::where('class_id', $classId)->get();
        
        $selectedModuleId = $request->input('module_id', $modules->first()?->id);
        $selectedModule = Module::find($selectedModuleId);
        $selectedGroupId = $request->input('group_id');
        
        $messages = [];
        $groupMap = null;

        if ($selectedModuleId && $classId) {
            $query = \App\Models\Message::where('module_id', $selectedModuleId)
                ->where('class_id', $classId);
            
            if ($selectedGroupId) {
                $query->where('group_id', $selectedGroupId);
                
                // Fetch Map for this group if it's a map module
                $discussionType = $selectedModule->content['D']['type'] ?? 'chat';
                if ($discussionType === 'map') {
                    $groupMap = \App\Models\GroupMap::where('group_id', $selectedGroupId)
                        ->where('module_id', $selectedModuleId)
                        ->first();
                }
            }

            $messages = $query->with(['user', 'group'])
                ->oldest()
                ->get();
        }

        return view('teacher.forum.index', compact('messages', 'modules', 'groups', 'selectedModuleId', 'selectedGroupId', 'class', 'classes', 'selectedModule', 'groupMap'));
    }

    public function export()
    {
        $teacher = Auth::user();
        $class = SchoolClass::find($teacher->class_id);
        $students = User::where('role', 'student')
                        ->where('class_id', $teacher->class_id)
                        ->orderBy('name')
                        ->get();

        $fileName = 'Laporan_Siswa_' . str_replace(' ', '_', $class->name) . '_' . date('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Nama Siswa', 'Email', 'Total Poin', 'Modul Selesai', 'Terakhir Aktif');

        $callback = function() use($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $student) {
                $completedCount = $student->progress()->where('is_completed', true)->count();
                $row['Nama Siswa']   = $student->name;
                $row['Email']        = $student->email;
                $row['Total Poin']   = $student->points;
                $row['Modul Selesai'] = $completedCount;
                $row['Terakhir Aktif'] = $student->updated_at->format('d/m/Y H:i');

                fputcsv($file, array($row['Nama Siswa'], $row['Email'], $row['Total Poin'], $row['Modul Selesai'], $row['Terakhir Aktif']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function groups(Request $request)
    {
        $user = Auth::user();
        $classId = $request->input('class_id', $user->class_id);
        if (!$classId && $user->role === 'admin') $classId = SchoolClass::first()?->id;

        $class = SchoolClass::find($classId);
        $classes = SchoolClass::all();

        $groups = StudentGroup::where('class_id', $classId)
                             ->with('students')
                             ->get();
        
        $students = User::where('role', 'student')
                        ->where('class_id', $classId)
                        ->orderBy('name')
                        ->get();

        return view('teacher.groups.index', compact('groups', 'students', 'class', 'classes'));
    }

    public function storeGroup(Request $request)
    {
        $teacher = Auth::user();
        $request->validate(['name' => 'required|string|max:100']);

        StudentGroup::create([
            'name' => $request->name,
            'teacher_id' => $teacher->id,
            'class_id' => $request->input('class_id', $teacher->class_id),
        ]);

        return back()->with('success', 'Kelompok berhasil dibuat.');
    }

    public function deleteGroup(StudentGroup $group)
    {
        $teacher = Auth::user();
        if ($group->teacher_id !== $teacher->id && $teacher->role !== 'admin') abort(403);
        
        // Unassign students first (set group_id to null is handled by migration onDelete set null)
        $group->delete();

        return back()->with('success', 'Kelompok berhasil dihapus.');
    }

    public function assignStudents(Request $request, StudentGroup $group)
    {
        $teacher = Auth::user();
        if ($group->teacher_id !== $teacher->id && $teacher->role !== 'admin') abort(403);

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        // Remove these students from any other group in this class (if needed) or just update them
        User::whereIn('id', $request->student_ids)->update(['group_id' => $group->id]);

        return back()->with('success', 'Siswa berhasil dimasukkan ke kelompok.');
    }
}
