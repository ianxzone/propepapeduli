<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'content' => 'required|string|max:500',
        ]);

        $user = Auth::user();

        $message = Message::create([
            'user_id' => $user->id,
            'module_id' => $request->module_id,
            'class_id' => $user->class_id,
            'group_id' => $user->group_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('user'),
        ]);
    }

    public function saveMap(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'content' => 'required|array',
        ]);

        $user = Auth::user();
        if (!$user->group_id) {
            return response()->json(['success' => false, 'message' => 'Anda harus berada dalam kelompok untuk menyimpan peta.'], 403);
        }

        $map = \App\Models\GroupMap::updateOrCreate(
            ['group_id' => $user->group_id, 'module_id' => $request->module_id],
            ['content' => $request->content]
        );

        return response()->json([
            'success' => true,
            'map' => $map,
        ]);
    }

    public function getMap(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'group_id' => 'nullable|exists:student_groups,id',
        ]);

        $user = Auth::user();
        $groupId = $request->group_id;
        
        // If teacher/admin, they specify group_id. If student, use their group_id.
        if ($user->role === 'student') {
            $groupId = $user->group_id;
        }

        if (!$groupId) {
            return response()->json(['success' => false, 'message' => 'Group not found'], 404);
        }

        $map = \App\Models\GroupMap::where('group_id', $groupId)
            ->where('module_id', $request->module_id)
            ->first();

        return response()->json([
            'success' => true,
            'map' => $map,
        ]);
    }
}
