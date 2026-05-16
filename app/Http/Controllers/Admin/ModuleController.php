<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function __construct()
    {
        // Add middleware if not done in routes
    }

    public function index()
    {
        $modules = Module::latest()->get();
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        return view('admin.modules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:modules',
            'description' => 'required|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_url' => 'nullable|url',
            'badge_name' => 'nullable|string|max:100',
            'badge_icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $thumbnail = $request->thumbnail_url;

        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/modules'), $filename);
            $thumbnail = asset('uploads/modules/' . $filename);
        }

        $slug = $request->slug ?: \Illuminate\Support\Str::slug($request->title);

        Module::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'thumbnail' => $thumbnail ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA9yqfYEBcbNVaJBf6CnY12Ief-6eZDZAS2gOMaG3UzDS9WN9pY7zC2fLoTj2QUSPAISSvzVxlAUoWKgEx2kE824vJdqU9MkjHwHYxOT4clYKHwq-CwPlY1-s6lGn2vcu05_mRtrQSFErf-6ma90o6k-YrQkJhujSeJmfGMaupfaU8iC-4dp5WOCI8QusjjJU61FIX1kbNdxZtMIU2zbysu1yXI4Xq-0zrltzIkwwqYOQG2gMkdLl2DwAZo26-sWHUWQWv01zvCVYmD',
            'badge_name' => $request->badge_name,
            'badge_icon' => $request->badge_icon,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dibuat.');
    }

    public function edit(Module $module)
    {
        return view('admin.modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:modules,slug,' . $module->id,
            'description' => 'required|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_url' => 'nullable|url',
            'badge_name' => 'nullable|string|max:100',
            'badge_icon' => 'nullable|string|max:50',
        ]);

        $thumbnail = $request->thumbnail_url ?: $module->thumbnail;

        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/modules'), $filename);
            $thumbnail = asset('uploads/modules/' . $filename);
        }

        $slug = $request->slug ?: \Illuminate\Support\Str::slug($request->title);

        $module->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'badge_name' => $request->badge_name,
            'badge_icon' => $request->badge_icon,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function content(Module $module)
    {
        $content = $module->content ?? [
            'P' => ['video_url' => '', 'text' => '', 'file_url' => ''],
            'E' => ['text' => ''],
            'D' => ['topic' => ''],
            'U' => ['task' => ''],
            'L' => ['task' => ''],
            'I' => ['questions' => ''],
            'essay' => [
                'question_emotional' => '', 
                'question_perspective' => '', 
                'question_care' => '', 
                'question_responsibility' => '', 
                'teacher_instruction' => ''
            ],
        ];
        return view('admin.modules.content', compact('module', 'content'));
    }

    public function updateContent(Request $request, Module $module)
    {
        $module->update(['content' => $request->content]);
        return redirect()->route('admin.modules.index')->with('success', 'Konten modul berhasil diperbarui.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus.');
    }
}
