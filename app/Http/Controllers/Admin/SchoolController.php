<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::withCount('classes')->latest()->get();
        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        School::create($request->all());

        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil didaftarkan.');
    }

    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $school->update($request->all());

        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    public function destroy(School $school)
    {
        // Check if there are classes associated
        if ($school->classes()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus sekolah yang memiliki kelas.');
        }

        $school->delete();
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
