<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = Media::latest();

        if ($type) {
            $query->where('type', $type);
        }

        if ($request->ajax() || $request->query('ajax')) {
            $media = $query->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'url' => Storage::disk('public')->url($item->path),
                    'filename' => $item->filename,
                    'original_name' => $item->original_name,
                    'type' => $item->type,
                    'human_size' => $item->human_size,
                    'extension' => $item->extension,
                ];
            });
            return response()->json($media);
        }

        $media = $query->paginate(24);
        return view('admin.media.index', compact('media', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:20480', // 20MB Max
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();
        
        $type = 'other';
        if (str_contains($mimeType, 'image')) $type = 'image';
        elseif (str_contains($mimeType, 'video')) $type = 'video';
        elseif (str_contains($mimeType, 'pdf') || str_contains($mimeType, 'document') || str_contains($mimeType, 'msword') || str_contains($mimeType, 'officedocument')) $type = 'document';

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        // Store in 'media' folder on 'public' disk
        $path = $file->storeAs('media', $filename, 'public');

        $media = Media::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'path' => $path, // This will be 'media/filename.jpg'
            'size' => $size,
            'type' => $type,
            'uploaded_by' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json($media);
        }

        return back()->with('success', 'Media berhasil diunggah.');
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $media->update($request->only('alt_text', 'caption', 'description'));

        if ($request->ajax()) {
            return response()->json(['success' => true, 'media' => $media]);
        }

        return back()->with('success', 'Metadata media diperbarui.');
    }

    public function destroy(Media $media)
    {
        Storage::delete($media->path);
        $media->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Media dihapus.');
    }
}
