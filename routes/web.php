<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\ModuleController as StudentModule;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;

Route::get('/', function () {
    return view('welcome');
});

// Student Auth
Route::get('/login', [StudentAuthController::class, 'showLogin'])->name('login'); // Also serves as 'student.login'
Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
Route::get('/select-name', [StudentAuthController::class, 'showSelectName'])->name('student.select.name');
Route::post('/select-name', [StudentAuthController::class, 'selectName'])->name('student.select.submit');

// Teacher Auth
Route::get('/guru/login', [TeacherAuthController::class, 'showLogin'])->name('teacher.login');
Route::post('/guru/login', [TeacherAuthController::class, 'login'])->name('teacher.login.submit');
Route::post('/guru/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');

// Student Area
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');
    Route::get('/leaderboard', [StudentDashboard::class, 'leaderboard'])->name('student.leaderboard');
    Route::get('/journals', [App\Http\Controllers\Student\JournalController::class, 'index'])->name('student.journals.index');
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'show'])->name('student.profile');
    Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('student.logout');
    Route::get('/modules/{module}', [StudentModule::class, 'show'])->name('student.module.show');
    Route::get('/modules/{module}/step/{step}', [StudentModule::class, 'showStep'])->name('student.module.step');
    Route::post('/modules/{module}/step/{step}/next', [StudentModule::class, 'nextStep'])->name('student.module.next');
    Route::post('/discussion/messages', [App\Http\Controllers\Student\DiscussionController::class, 'store'])->name('student.discussion.store');
});

// Admin Auth
Route::get('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminAuthController::class, 'logout'])->name('admin.logout');

// Teacher Area
Route::middleware(['auth'])->prefix('guru')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
    Route::get('/student/{student}', [TeacherDashboard::class, 'studentDetail'])->name('student.detail');
    Route::get('/journals', [TeacherDashboard::class, 'journals'])->name('journals.index');
    Route::post('/journal/{journal}/feedback', [TeacherDashboard::class, 'saveFeedback'])->name('journal.feedback');
    Route::get('/forum', [TeacherDashboard::class, 'forum'])->name('forum.index');
    Route::get('/export', [TeacherDashboard::class, 'export'])->name('export');
    Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');
});

// Admin Area
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('modules', App\Http\Controllers\Admin\ModuleController::class, ['as' => 'admin']);
    Route::get('modules/{module}/content', [App\Http\Controllers\Admin\ModuleController::class, 'content'])->name('admin.modules.content');
    Route::post('modules/{module}/content', [App\Http\Controllers\Admin\ModuleController::class, 'updateContent'])->name('admin.modules.content.update');
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('classes', App\Http\Controllers\Admin\ClassController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class, ['as' => 'admin'])->except(['show']);
    
    // NEW: User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin'])->except(['show']);
    
    // NEW: General Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});
