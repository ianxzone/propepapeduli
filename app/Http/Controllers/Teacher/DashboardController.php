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
    public function index()
    {
        $teacher = Auth::user();
        
        // Ensure only teachers access this
        if ($teacher->role !== 'teacher') {
            return redirect()->route('student.dashboard');
        }

        $class = SchoolClass::with('school')->find($teacher->class_id);
        
        if (!$class) {
            return redirect()->route('login')->with('error', 'Akun guru Anda tidak terhubung dengan kelas manapun.');
        }
        
        // Get all active modules
        $modules = Module::where('is_active', true)->get();
        
        // Get all students in this class
        $students = User::where('role', 'student')
                        ->where('class_id', $class->id)
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

        return view('teacher.dashboard', compact('teacher', 'class', 'students', 'modules', 'averagePoints', 'totalStudents', 'phaseStats'));
    }

    public function journals()
    {
        $teacher = Auth::user();
        $class = SchoolClass::find($teacher->class_id);
        
        // Get all journals from students in this class
        $journals = Journal::whereIn('user_id', function($query) use ($teacher) {
            $query->select('id')->from('users')->where('class_id', $teacher->class_id);
        })->with(['user', 'module'])->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.journals.index', compact('journals', 'class'));
    }

    public function studentDetail(User $student)
    {
        $teacher = Auth::user();
        if ($teacher->role !== 'teacher' || $student->class_id !== $teacher->class_id) {
            abort(403);
        }

        $modules = Module::where('is_active', true)->get();
        $journals = $student->journals()->with('module')->orderBy('created_at', 'desc')->get();
        
        return view('teacher.student-detail', compact('student', 'modules', 'journals'));
    }

    public function saveFeedback(Request $request, Journal $journal)
    {
        $teacher = Auth::user();
        if ($teacher->role !== 'teacher') abort(403);

        $request->validate([
            'teacher_feedback' => 'nullable|string',
            'teacher_points' => 'required|integer|min:0|max:50',
        ]);

        $journal->update([
            'teacher_feedback' => $request->teacher_feedback,
            'teacher_points' => $request->teacher_points,
        ]);

        // Reward the student
        if ($request->teacher_points > 0) {
            $journal->user->increment('points', $request->teacher_points);
            \App\Models\PointsLog::create([
                'user_id' => $journal->user->id,
                'points' => $request->teacher_points,
                'activity_type' => "Bonus Jurnal oleh Guru",
            ]);
        }

        return back()->with('success', 'Umpan balik berhasil disimpan.');
    }

    public function forum(Request $request)
    {
        $teacher = Auth::user();
        $class = SchoolClass::find($teacher->class_id);
        $modules = Module::where('is_active', true)->get();
        $groups = StudentGroup::where('class_id', $teacher->class_id)->get();
        
        $selectedModuleId = $request->input('module_id', $modules->first()?->id);
        $selectedGroupId = $request->input('group_id');
        
        $messages = [];
        if ($selectedModuleId) {
            $query = \App\Models\Message::where('module_id', $selectedModuleId)
                ->where('class_id', $teacher->class_id);
            
            if ($selectedGroupId) {
                $query->where('group_id', $selectedGroupId);
            }

            $messages = $query->with(['user', 'group'])
                ->oldest()
                ->get();
        }

        return view('teacher.forum.index', compact('messages', 'modules', 'groups', 'selectedModuleId', 'selectedGroupId', 'class'));
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
    public function groups()
    {
        $teacher = Auth::user();
        $class = SchoolClass::find($teacher->class_id);
        $groups = StudentGroup::where('teacher_id', $teacher->id)
                             ->where('class_id', $teacher->class_id)
                             ->with('students')
                             ->get();
        
        $students = User::where('role', 'student')
                        ->where('class_id', $teacher->class_id)
                        ->orderBy('name')
                        ->get();

        return view('teacher.groups.index', compact('groups', 'students', 'class'));
    }

    public function storeGroup(Request $request)
    {
        $teacher = Auth::user();
        $request->validate(['name' => 'required|string|max:100']);

        StudentGroup::create([
            'name' => $request->name,
            'teacher_id' => $teacher->id,
            'class_id' => $teacher->class_id,
        ]);

        return back()->with('success', 'Kelompok berhasil dibuat.');
    }

    public function deleteGroup(StudentGroup $group)
    {
        $teacher = Auth::user();
        if ($group->teacher_id !== $teacher->id) abort(403);
        
        // Unassign students first (set group_id to null is handled by migration onDelete set null)
        $group->delete();

        return back()->with('success', 'Kelompok berhasil dihapus.');
    }

    public function assignStudents(Request $request, StudentGroup $group)
    {
        $teacher = Auth::user();
        if ($group->teacher_id !== $teacher->id) abort(403);

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        // Remove these students from any other group in this class (if needed) or just update them
        User::whereIn('id', $request->student_ids)->update(['group_id' => $group->id]);

        return back()->with('success', 'Siswa berhasil dimasukkan ke kelompok.');
    }
}
