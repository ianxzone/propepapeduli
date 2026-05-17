<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\ModuleController as StudentModule;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;

Route::get('/', function () {
    $teams = \App\Models\Team::where('is_active', true)->orderBy('order')->get();
    $topStudents = \App\Models\User::where('role', 'student')
        ->orderBy('points', 'desc')
        ->limit(2)
        ->get();
    return view('welcome', compact('teams', 'topStudents'));
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/team/{team}', function (\App\Models\Team $team) {
    if (!$team->is_active) abort(404);
    return view('team-detail', compact('team'));
})->name('team.show');

// Student Auth
Route::get('/login', [StudentAuthController::class, 'showLogin'])->name('login'); // Also serves as 'student.login'
Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
Route::get('/select-name', [StudentAuthController::class, 'showSelectName'])->name('student.select.name');
Route::post('/select-name', [StudentAuthController::class, 'selectName'])->name('student.select.submit');

// Teacher Auth
Route::get('/guru/login', [TeacherAuthController::class, 'showLogin'])->name('teacher.login');
Route::post('/guru/login', [TeacherAuthController::class, 'login'])->name('teacher.login.submit');

// Student Area
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');
    Route::get('/leaderboard', [StudentDashboard::class, 'leaderboard'])->name('student.leaderboard');
    Route::get('/journals', [App\Http\Controllers\Student\JournalController::class, 'index'])->name('student.journals.index');
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'show'])->name('student.profile');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
    Route::get('/modules/{module}', [StudentModule::class, 'show'])->name('student.module.show');
    Route::get('/modules/{module}/step/{step}', [StudentModule::class, 'showStep'])->name('student.module.step');
    Route::post('/modules/{module}/step/{step}/next', [StudentModule::class, 'nextStep'])->name('student.module.next');
    Route::post('/discussion/messages', [App\Http\Controllers\Student\DiscussionController::class, 'store'])->name('student.discussion.store');
    Route::post('/discussion/map', [App\Http\Controllers\Student\DiscussionController::class, 'saveMap'])->name('student.discussion.map.save');
    Route::get('/discussion/map', [App\Http\Controllers\Student\DiscussionController::class, 'getMap'])->name('student.discussion.map.get');
});

// Admin Auth
Route::get('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminAuthController::class, 'logout'])->name('admin.logout');

// Teacher Area
Route::middleware(['auth'])->prefix('guru')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
    Route::get('/students', [TeacherDashboard::class, 'students'])->name('students.index');
    Route::get('/students/create', [TeacherDashboard::class, 'createStudent'])->name('students.create');
    Route::post('/students/store', [TeacherDashboard::class, 'storeStudent'])->name('students.store');
    Route::get('/students/import', [TeacherDashboard::class, 'showImportStudents'])->name('students.import');
    Route::get('/students/import/sample', [TeacherDashboard::class, 'downloadSampleCsv'])->name('students.import.sample');
    Route::post('/students/import', [TeacherDashboard::class, 'importStudents'])->name('students.import.submit');
    Route::get('/student/{student}', [TeacherDashboard::class, 'studentDetail'])->name('student.detail');
    Route::delete('/student/{student}/delete', [TeacherDashboard::class, 'deleteStudent'])->name('student.delete');
    Route::get('/journals', [TeacherDashboard::class, 'journals'])->name('journals.index');
    Route::post('/journal/{journal}/feedback', [TeacherDashboard::class, 'saveFeedback'])->name('journal.feedback');
    Route::get('/forum', [TeacherDashboard::class, 'forum'])->name('forum.index');
    Route::get('/groups', [TeacherDashboard::class, 'groups'])->name('groups.index');
    Route::post('/groups', [TeacherDashboard::class, 'storeGroup'])->name('groups.store');
    Route::delete('/groups/{group}', [TeacherDashboard::class, 'deleteGroup'])->name('groups.delete');
    Route::post('/groups/{group}/assign', [TeacherDashboard::class, 'assignStudents'])->name('groups.assign');
    Route::get('/reports', [TeacherDashboard::class, 'reports'])->name('reports.index');
    Route::get('/export', [TeacherDashboard::class, 'export'])->name('export');
    Route::get('/export-assessments', [TeacherDashboard::class, 'exportAssessments'])->name('export.assessments');
    Route::get('/notifications', [App\Http\Controllers\Teacher\NotificationController::class, 'index'])->name('notifications');
    Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');
});

// Admin Area
Route::middleware(['auth', 'admin_dosen'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('modules', App\Http\Controllers\Admin\ModuleController::class, ['as' => 'admin']);
    Route::get('modules/{module}/content', [App\Http\Controllers\Admin\ModuleController::class, 'content'])->name('admin.modules.content');
    Route::post('modules/{module}/content', [App\Http\Controllers\Admin\ModuleController::class, 'updateContent'])->name('admin.modules.content.update');
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('classes', App\Http\Controllers\Admin\ClassController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class, ['as' => 'admin'])->except(['show']);
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class, ['as' => 'admin']);
    
    // NEW: User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin'])->except(['show']);
    
    // NEW: Media Library
    Route::resource('media', App\Http\Controllers\Admin\MediaController::class, ['as' => 'admin'])->except(['show', 'create', 'edit']);
    
    // NEW: Team Management
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class, ['as' => 'admin'])->except(['show']);
    
    // NEW: General Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    // NEW: Activity Logs
    Route::get('/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
    Route::delete('/activity-logs/clear', [App\Http\Controllers\Admin\ActivityLogController::class, 'clear'])->name('admin.activity-logs.clear');

    // NEW: Backups
    Route::get('/backups', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('admin.backups.index');
    Route::post('/backups', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('admin.backups.create');
    Route::get('/backups/download/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('admin.backups.download');
    Route::delete('/backups/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('admin.backups.delete');
    // NEW: Setup Wizard
    Route::get('/setup-wizard', [App\Http\Controllers\Admin\SetupWizardController::class, 'index'])->name('admin.setup.wizard');
    Route::post('/setup-wizard', [App\Http\Controllers\Admin\SetupWizardController::class, 'save'])->name('admin.setup.save');
});

// Common route for Admin, Dosen, and Teacher
Route::middleware(['auth'])->group(function () {
    Route::get('/about-app', function () {
        if (!in_array(Auth::user()->role, ['admin', 'dosen', 'teacher'])) {
            abort(403, 'Akses ditolak.');
        }
        $teams = \App\Models\Team::where('is_active', true)->orderBy('order')->get();
        return view('admin.about_app', compact('teams'));
    })->name('admin.about-app');
});
