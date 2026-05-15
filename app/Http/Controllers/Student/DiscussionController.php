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
}
