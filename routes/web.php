<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ProductivityController;
use App\Http\Controllers\Dashboard\AttachmentController;
use App\Http\Controllers\dashboard\CalendarController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\DesignationController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\Reports\MemberReportController;
use App\Http\Controllers\Dashboard\Reports\ProjectReportController;
use App\Http\Controllers\Dashboard\Reports\TaskReportController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\TaskCommentController;
use App\Http\Controllers\Dashboard\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->name('dashboard.')->middleware(['auth:admin', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class);
    Route::resource('roles', RoleController::class);
    Route::put('roles/permissions/edit', [RoleController::class, 'updateRolePermission'])->name('roles.updateRolePermission');
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('members', MemberController::class);
    Route::get('members/designation/filter/{department}', [DesignationController::class, 'designationFilterCreate']);
    Route::get('members/{member}/designation/filter/{department}', [DesignationController::class, 'designationFilterEdit']);
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('reports/project', [ProjectReportController::class, 'index'])->name('reports.project.index');
    Route::get('reports/project/{project}', [ProjectReportController::class, 'project'])->name('reports.project.project');
    Route::get('reports/project/filter/pdf', [ProjectReportController::class, 'downloadPdf'])->name('projects.pdf');
    Route::get('reports/project/{project}/pdf', [ProjectReportController::class, 'projectpdf'])->name('project.pdf');
});

Route::prefix('/')->name('dashboard.')->middleware(['auth:admin,member'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('projects/members/filter/{department}', [MemberController::class, 'projectManagerFilterCreate']);
    Route::get('projects/{member}/members/filter/{department}', [MemberController::class, 'projectManagerFilterEdit']);
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/project/filter/{department}', [TaskController::class, 'projectFilterCreate']);
    Route::get('tasks/members/filter/{department}', [TaskController::class, 'membersFilterCreate']);
    Route::get('tasks/{task}/project/filter/{department}', [TaskController::class, 'projectFilterEdit']);
    Route::get('tasks/{task}/members/filter/{department}', [TaskController::class, 'membersFilterEdit']);
    Route::resource('attachments', AttachmentController::class);
    Route::get('attachments/task/{task}', [AttachmentController::class, 'task']);
    Route::get('attachments/project/{project}', [AttachmentController::class, 'project']);
    Route::get('attachments/view/{attachment}', [AttachmentController::class, 'view'])->name('view');
    Route::resource('productivities', ProductivityController::class);
    Route::get('project/search', [ProjectController::class, 'search'])->name('project.search');

    Route::get('productivities/task/filter/{project}', [ProductivityController::class, 'taskFilterCreate']);

    Route::get('reports/task', [TaskReportController::class, 'index'])->name('reports.task.index');
    Route::get('reports/task/{task}', [TaskReportController::class, 'task'])->name('reports.task.task');
    Route::get('reports/task/filter/pdf', [TaskReportController::class, 'downloadPdf'])->name('tasks.pdf');
    Route::get('reports/task/{task}/pdf', [TaskReportController::class, 'taskpdf'])->name('task.pdf');

    Route::get('reports/member', [MemberReportController::class, 'index'])->name('reports.member.index');
    Route::get('reports/member/filter/pdf', [MemberReportController::class, 'downloadPdf'])->name('members.pdf');
    Route::get('reports/member/{member}', [MemberReportController::class, 'member'])->name('reports.member.member');
    Route::get('reports/member/{member}/pdf', [MemberReportController::class, 'memberPdf'])->name('member.pdf');

    Route::get('calendar', [CalendarController::class, 'calendar'])->name('calendar');
    Route::resource('comments', TaskCommentController::class);
});


Route::prefix('/')->middleware(['auth:admin,member', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard.home');
    Route::get('profile/edit', [AuthController::class, 'editUser'])->name('auth.editProfile');
    Route::put('profile/edit', [AuthController::class, 'updateUser'])->name('auth.updateProfile');
    Route::put('edit/image', [AuthController::class, 'saveImage'])->name('saveImage');
    Route::put('profile/password/edit', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');
    Route::get('notifications', [AuthController::class, 'notifications'])->name('auth.notifications');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::prefix('/auth')->middleware('guest:admin,member')->group(function () {
    Route::get('home', function () {
        return view('dashboard.auth.home');
    })->name('login');
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('auth.showlogin');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forget');
    Route::post('forgot-password', [AuthController::class, 'sendResetEmail'])->name('auth.send');
    Route::get('forgot-password/{token}', [AuthController::class, 'recoverPassword'])->name('password.reset');
    Route::put('forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::prefix('email/verification')->middleware('auth:admin,member')->group(function () {
    Route::get('', [AuthController::class, 'showEmailVerification'])->name('verification.notice');
    Route::post('', [AuthController::class, 'sendVerifyEmail'])->middleware('throttle:3,3')->name('sendVerifyEmail');
    Route::get('/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');
});
