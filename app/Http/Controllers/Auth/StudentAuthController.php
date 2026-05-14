<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'class_code' => 'required',
        ]);

        $class = SchoolClass::where('class_code', $request->class_code)->first();

        if (!$class) {
            return back()->withErrors(['class_code' => 'Kode kelas tidak ditemukan.']);
        }

        session(['pending_class_id' => $class->id]);

        return redirect()->route('student.select.name');
    }

    public function showSelectName()
    {
        $classId = session('pending_class_id');
        if (!$classId) return redirect()->route('login');

        $class = SchoolClass::with('school')->find($classId);
        $students = User::where('class_id', $classId)->where('role', 'student')->get();

        return view('auth.select-name', compact('students', 'class'));
    }

    public function selectName(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        
        Auth::login($user);
        
        session()->forget('pending_class_id');

        return redirect()->route('student.dashboard');
    }
}
