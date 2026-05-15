<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('school')->withCount('students')->latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $schools = School::all();
        return view('admin.classes.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
        ]);

        SchoolClass::create([
            'name' => $request->name,
            'school_id' => $request->school_id,
            'class_code' => strtoupper(\Illuminate\Support\Str::random(6)),
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function edit(SchoolClass $class)
    {
        $schools = School::all();
        return view('admin.classes.edit', compact('class', 'schools'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
        ]);

        $class->update([
            'name' => $request->name,
            'school_id' => $request->school_id,
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        if ($class->students()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa.');
        }

        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
