<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = \App\Models\Team::orderBy('order')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nidn' => 'nullable|string|max:50',
            'academic_rank' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'bio' => 'nullable|string',
            'education' => 'nullable|string',
            'expertise' => 'nullable|string',
            'journal_links' => 'nullable|string',
            'google_scholar' => 'nullable|string',
            'sinta_link' => 'nullable|string',
            'scopus_link' => 'nullable|string',
            'orcid_link' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        if ($request->filled('journal_links')) {
            $data['journal_links'] = array_filter(array_map('trim', explode("\n", $request->journal_links)));
        }
        if ($request->filled('education')) {
            $data['education'] = array_filter(array_map('trim', explode("\n", $request->education)));
        }

        \App\Models\Team::create($data);

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(\App\Models\Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, \App\Models\Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nidn' => 'nullable|string|max:50',
            'academic_rank' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'bio' => 'nullable|string',
            'education' => 'nullable|string',
            'expertise' => 'nullable|string',
            'journal_links' => 'nullable|string',
            'google_scholar' => 'nullable|string',
            'sinta_link' => 'nullable|string',
            'scopus_link' => 'nullable|string',
            'orcid_link' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        if ($request->has('journal_links')) {
            $data['journal_links'] = $request->filled('journal_links') 
                ? array_filter(array_map('trim', explode("\n", $request->journal_links)))
                : [];
        }
        if ($request->has('education')) {
            $data['education'] = $request->filled('education') 
                ? array_filter(array_map('trim', explode("\n", $request->education)))
                : [];
        }

        $team->update($data);

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(\App\Models\Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
