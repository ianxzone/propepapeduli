<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->with('class.school');

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $classes = SchoolClass::with('school')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::with('school')->get();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'points' => 'nullable|integer|min:0',
        ]);

        User::create([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'points' => $request->points ?? 0,
            'role' => 'student',
            // Default password for students if they ever need direct login, 
            // though currently they use class code + name selection.
            'password' => bcrypt('123456'), 
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function edit(User $student)
    {
        if ($student->role !== 'student') abort(404);
        $classes = SchoolClass::with('school')->get();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function show(User $student)
    {
        if ($student->role !== 'student') abort(404);
        
        $journals = \App\Models\Journal::where('user_id', $student->id)
                                    ->with('module')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('admin.students.show', compact('student', 'journals'));
    }

    public function update(Request $request, User $student)
    {
        if ($student->role !== 'student') abort(404);

        $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'points' => 'required|integer|min:0',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy(User $student)
    {
        if ($student->role !== 'student') abort(404);
        
        // Optionally check for progress data before deleting
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil dihapus.');
    }
}
