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
        
        // Ensure only teachers, admins, or dosen access this
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) {
            return redirect()->route('student.dashboard');
        }

        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && in_array($teacher->role, ['admin', 'dosen'])) {
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
            'P' => 0, 'E' => 0, 'D' => 0, 'U' => 0, 'L' => 0, 'I' => 0, 'S' => 0
        ];

        foreach ($students as $student) {
            $progresses = $student->progress;
            foreach ($progresses as $prog) {
                // We count how many students have reached/passed each phase
                $phases = ['P', 'E', 'D', 'U', 'L', 'I', 'S'];
                $currentIndex = array_search($prog->current_step, $phases);
                for ($i = 0; $i <= $currentIndex; $i++) {
                    $phaseStats[$phases[$i]]++;
                }
            }
        }

        return view('teacher.dashboard', compact('class', 'classes', 'students', 'modules', 'totalStudents', 'averagePoints', 'phaseStats'));
    }

    public function students(Request $request)
    {
        $teacher = Auth::user();
        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && in_array($teacher->role, ['admin', 'dosen'])) $classId = SchoolClass::first()?->id;

        $class = SchoolClass::with('school')->find($classId);
        $classes = SchoolClass::all();

        $students = User::where('role', 'student')
                        ->where('class_id', $classId)
                        ->when($request->search, function($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orderBy('name')
                        ->paginate(20);

        return view('teacher.students.index', compact('students', 'class', 'classes'));
    }

    public function journals(Request $request)
    {
        $teacher = Auth::user();
        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && in_array($teacher->role, ['admin', 'dosen'])) $classId = SchoolClass::first()?->id;

        $class = SchoolClass::find($classId);
        $classes = SchoolClass::all();
        
        // Get all journals from students in this class
        $journals = Journal::whereIn('user_id', function($query) use ($classId) {
            $query->select('id')->from('users')->where('class_id', $classId);
        })->with(['user', 'module'])->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.journals.index', compact('journals', 'class', 'classes'));
    }

    public function studentDetail(Request $request, User $student)
    {
        $teacher = Auth::user();
        if (in_array($student->role, ['teacher', 'dosen'])) abort(404);
        
        $selectedModuleId = $request->input('module_id');
        $modules = Module::where('is_active', true)->get();
        
        $journalsQuery = Journal::where('user_id', $student->id)->with('module');
        if ($selectedModuleId) {
            $journalsQuery->where('module_id', $selectedModuleId);
        }
        $journals = $journalsQuery->orderBy('created_at', 'desc')->get();

        return view('teacher.student-detail', compact('student', 'journals', 'modules', 'selectedModuleId'));
    }

    public function saveFeedback(Request $request, Journal $journal)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) abort(403);

        $request->validate([
            'teacher_feedback' => 'nullable|string',
            'teacher_points' => 'required|integer',
            'score_emotional' => 'nullable|integer|between:1,4',
            'score_perspective' => 'nullable|integer|between:1,4',
            'score_care' => 'nullable|integer|between:1,4',
            'score_responsibility' => 'nullable|integer|between:1,4',
        ]);

        $oldPoints = $journal->teacher_points;

        $journal->update([
            'teacher_feedback' => $request->teacher_feedback,
            'teacher_points' => $request->teacher_points,
            'score_emotional' => $request->score_emotional,
            'score_perspective' => $request->score_perspective,
            'score_care' => $request->score_care,
            'score_responsibility' => $request->score_responsibility,
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
        if (!$classId && in_array($user->role, ['admin', 'dosen'])) $classId = SchoolClass::first()?->id;
        
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

    public function reports(Request $request)
    {
        $user = Auth::user();
        $classId = $request->input('class_id', $user->class_id);
        if (!$classId && in_array($user->role, ['admin', 'dosen'])) $classId = SchoolClass::first()?->id;

        $class = SchoolClass::find($classId);
        $classes = SchoolClass::all();

        $assessments = Journal::whereHas('user', function($q) use ($classId) {
            $q->where('class_id', $classId);
        })->where('step', 'S')->with('user', 'module')->orderBy('created_at', 'desc')->get();

        return view('teacher.reports.index', compact('class', 'classes', 'assessments'));
    }

    public function exportAssessments(Request $request)
    {
        $teacher = Auth::user();
        $classId = $request->input('class_id', $teacher->class_id);
        $class = SchoolClass::find($classId);
        
        $fileName = 'Laporan_Penilaian_Empati_' . str_replace(' ', '_', $class->name) . '_' . date('Ymd') . '.csv';
        
        $journals = Journal::whereHas('user', function($q) use ($classId) {
            $q->where('class_id', $classId);
        })->where('step', 'S')->with('user', 'module')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Nama Siswa', 'Modul', 'Jawaban Essay', 'Emosional (1-4)', 'Perspektif (1-4)', 'Kepedulian (1-4)', 'Tanggung Jawab (1-4)', 'Total Nilai (0-100)', 'Umpan Balik Guru');

        $callback = function() use($journals, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($journals as $journal) {
                fputcsv($file, array(
                    $journal->user->name,
                    $journal->module->title,
                    $journal->content,
                    $journal->score_emotional ?? '-',
                    $journal->score_perspective ?? '-',
                    $journal->score_care ?? '-',
                    $journal->score_responsibility ?? '-',
                    $journal->teacher_points,
                    $journal->teacher_feedback ?? '-'
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function export(Request $request)
    {
        $teacher = Auth::user();
        $classId = $request->input('class_id', $teacher->class_id);
        $class = SchoolClass::find($classId);
        
        $fileName = 'Laporan_Siswa_' . str_replace(' ', '_', $class->name) . '_' . date('Ymd') . '.csv';
        $students = User::where('role', 'student')
                        ->where('class_id', $classId)
                        ->get();

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

    public function createStudent(Request $request)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) {
            abort(403);
        }

        $classes = SchoolClass::with('school')->get();
        
        // Determine selected class
        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && in_array($teacher->role, ['admin', 'dosen'])) {
            $classId = $classes->first()?->id;
        }
        $class = SchoolClass::find($classId);

        return view('teacher.students.create', compact('classes', 'class', 'teacher'));
    }

    public function storeStudent(Request $request)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Security check: normal teacher can only add students to their own class
        if ($teacher->role === 'teacher' && $request->class_id != $teacher->class_id) {
            return back()->with('error', 'Anda hanya bisa menambahkan siswa ke kelas Anda sendiri.')->withInput();
        }

        User::create([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'points' => 0,
            'role' => 'student',
            'password' => bcrypt('123456'),
        ]);

        return redirect()->route('teacher.students.index', ['class_id' => $request->class_id])
            ->with('success', 'Siswa ' . $request->name . ' berhasil ditambahkan.');
    }

    public function showImportStudents(Request $request)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) {
            abort(403);
        }

        $classes = SchoolClass::with('school')->get();
        
        $classId = $request->input('class_id', $teacher->class_id);
        if (!$classId && in_array($teacher->role, ['admin', 'dosen'])) {
            $classId = $classes->first()?->id;
        }
        $class = SchoolClass::find($classId);

        return view('teacher.students.import', compact('classes', 'class', 'teacher'));
    }

    public function downloadSampleCsv()
    {
        $fileName = 'Template_Import_Siswa.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['name'];
        $samples = [
            ['Budi Darmawan'],
            ['Siti Aminah'],
            ['Ahmad Fauzi'],
            ['Dewi Lestari']
        ];

        $callback = function() use($columns, $samples) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($samples as $sample) {
                fputcsv($file, $sample);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importStudents(Request $request)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) {
            abort(403);
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'import_method' => 'required|in:file,paste',
            'import_file' => 'required_if:import_method,file|file|mimes:csv,txt|max:2048',
            'import_paste' => 'required_if:import_method,paste|string|nullable',
        ]);

        if ($teacher->role === 'teacher' && $request->class_id != $teacher->class_id) {
            return back()->with('error', 'Anda hanya bisa mengimpor siswa ke kelas Anda sendiri.')->withInput();
        }

        $classId = $request->class_id;
        $names = [];

        if ($request->import_method === 'file') {
            $file = $request->file('import_file');
            $path = $file->getRealPath();
            
            if (($handle = fopen($path, "r")) !== FALSE) {
                $header = fgetcsv($handle, 1000, ",");
                
                // If it's a simple TXT file or CSV without a strict name header, 
                // we check if the first column is 'name' or similar, else we treat the first line as a student if it's not a header.
                $isHeaderName = false;
                if ($header && (strtolower(trim($header[0])) === 'name' || strtolower(trim($header[0])) === 'nama')) {
                    $isHeaderName = true;
                } else if ($header) {
                    $names[] = trim($header[0]);
                }

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (isset($data[0]) && trim($data[0]) !== '') {
                        $names[] = trim($data[0]);
                    }
                }
                fclose($handle);
            }
        } else {
            // Paste method
            $lines = explode("\n", $request->import_paste);
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    // Check if it matches a CSV header to skip
                    if (strtolower($trimmed) === 'name' || strtolower($trimmed) === 'nama') {
                        continue;
                    }
                    $names[] = $trimmed;
                }
            }
        }

        if (count($names) === 0) {
            return back()->with('error', 'Tidak ada data nama siswa yang ditemukan atau terbaca.')->withInput();
        }

        $importedCount = 0;
        \Illuminate\Support\Facades\DB::transaction(function() use ($names, $classId, &$importedCount) {
            foreach ($names as $name) {
                User::create([
                    'name' => $name,
                    'class_id' => $classId,
                    'points' => 0,
                    'role' => 'student',
                    'password' => bcrypt('123456'),
                ]);
                $importedCount++;
            }
        });

        return redirect()->route('teacher.students.index', ['class_id' => $classId])
            ->with('success', 'Berhasil mengimpor ' . $importedCount . ' siswa baru.');
    }

    public function deleteStudent(User $student)
    {
        $teacher = Auth::user();
        if (!in_array($teacher->role, ['teacher', 'admin', 'dosen'])) {
            abort(403);
        }

        if ($student->role !== 'student') {
            abort(404);
        }

        // Security check: normal teacher can only delete students in their own class
        if ($teacher->role === 'teacher' && $student->class_id != $teacher->class_id) {
            abort(403, 'Akses ditolak untuk menghapus siswa di kelas lain.');
        }

        $student->delete();

        return back()->with('success', 'Siswa ' . $student->name . ' berhasil dihapus.');
    }
}
