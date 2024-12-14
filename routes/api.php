<?php

use App\Http\Controllers\Auth\AuthApiController;
use App\Http\Controllers\Dashboard\Api\AdminController;
use App\Http\Controllers\Dashboard\Api\AttachmentController;
use App\Http\Controllers\Dashboard\Api\DepartmentController;
use App\Http\Controllers\Dashboard\Api\DesignationController;
use App\Http\Controllers\Dashboard\Api\MemberController;
use App\Http\Controllers\Dashboard\Api\ProductivityController;
use App\Http\Controllers\Dashboard\Api\ProjectController;
use App\Http\Controllers\Dashboard\Api\Reports\MemberReportController;
use App\Http\Controllers\Dashboard\Api\Reports\ProjectReportController;
use App\Http\Controllers\Dashboard\Api\Reports\TaskReportController;
use App\Http\Controllers\Dashboard\Api\RoleController;
use App\Http\Controllers\Dashboard\Api\SettingController;
use App\Http\Controllers\Dashboard\Api\TaskActivityController;
use App\Http\Controllers\Dashboard\Api\TaskCommentController;
use App\Http\Controllers\Dashboard\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('dashboard')->middleware('auth:api-admin')->group(function () {
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('roles', RoleController::class);
    Route::put('permission/update', [RoleController::class, 'updateRolePermission']);
    Route::apiResource('members', MemberController::class);
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('designations', DesignationController::class);
    Route::get('settings', [SettingController::class, 'index']);
    Route::put('settings', [SettingController::class, 'update']);
    Route::get('reports/project/all', [ProjectReportController::class, 'projects']);
    Route::get('reports/project/status', [ProjectReportController::class, 'projectInStatus']);
    Route::get('reports/project/{project}', [ProjectReportController::class, 'project']);
    Route::get('reports/project/members/{project}', [ProjectReportController::class, 'members']);
    Route::get('reports/task/status', [TaskReportController::class, 'taskInStatus']);
    Route::get('reports/task/priority', [TaskReportController::class, 'taskInPriority']);
    Route::get('reports/task/{task}/activities', [TaskReportController::class, 'taskActivities']);
    Route::get('reports/task/{task}/productivities', [TaskReportController::class, 'taskProductivities']);
    Route::get('reports/task/{task}', [TaskReportController::class, 'task']);
    Route::get('reports/member/project/{project}/{member}', [MemberReportController::class, 'project']);
    Route::get('reports/member/task/{task}/{member}', [MemberReportController::class, 'task']);
    Route::get('reports/member/completion/{member}', [MemberReportController::class, 'taskCompletionReport']);
    Route::get('reports/member/completion', [MemberReportController::class, 'taskCompletionReportAll']);
});

Route::prefix('dashboard')->middleware('auth:api-admin,api-member')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::put('projects/status/change/{project}', [ProjectController::class, 'change_status']);
    Route::apiResource('tasks', TaskController::class);
    Route::put('tasks/status/change/{task}', [TaskController::class, 'change_status']);
    Route::apiResource('productivities', ProductivityController::class);
    Route::apiResource('comments', TaskCommentController::class);
    Route::get('activities/tasks', [TaskActivityController::class, 'index']);
    Route::get('activities/tasks/{task}', [TaskActivityController::class, 'show']);
    Route::apiResource('attachments', AttachmentController::class);
    Route::get('attachments/task/{task}', [AttachmentController::class, 'task']);
    Route::get('attachments/project/{project}', [AttachmentController::class, 'project']);
    Route::put('{guard}/profile/edit', [AuthApiController::class, 'updateProfile']);
    Route::put('{guard}/password/change', [AuthApiController::class, 'changePassword']);
    Route::get('{guard}/logout', [AuthApiController::class, 'logout']);
});

Route::prefix('auth')->group(function () {
    Route::post('{guard}/login', [AuthApiController::class, 'login']);
    // Route::post('{guard}/forgot/password', [AuthApiController::class, 'sendResetEmail']);
    // Route::post('forgot/password/{token}', [AuthApiController::class, 'passwordReset'])->name('password.reset');
    // Route::put('{guard}/recover/password', [AuthApiController::class, 'recoverPassword']);
});


// Route::prefix('email/verification')->middleware('auth:api-admin,api-member')->group(function () {
//     Route::post('{guard}/', [AuthApiController::class, 'sendVerifyEmail']);
//     Route::get('/{id}/{hash}', [AuthApiController::class, 'verify'])->middleware('signed')->name('verification.verify');
// });
