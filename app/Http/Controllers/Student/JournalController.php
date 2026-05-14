<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $journals = Journal::where('user_id', $user->id)
            ->with('module')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.journals.index', compact('user', 'journals'));
    }
}
