<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')->with('class.school')->latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classes = SchoolClass::with('school')->get();
        return view('admin.teachers.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Akun Guru berhasil dibuat.');
    }

    public function edit(User $teacher)
    {
        if ($teacher->role !== 'teacher') abort(404);
        $classes = SchoolClass::with('school')->get();
        return view('admin.teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, User $teacher)
    {
        if ($teacher->role !== 'teacher') abort(404);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',id,'.$teacher->id],
            'class_id' => ['required', 'exists:classes,id'],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'class_id' => $request->class_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')->with('success', 'Akun Guru berhasil diperbarui.');
    }

    public function destroy(User $teacher)
    {
        if ($teacher->role !== 'teacher') abort(404);
        
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Akun Guru berhasil dihapus.');
    }
}
