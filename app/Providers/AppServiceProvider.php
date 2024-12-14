<?php

namespace App\Providers;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Task;
use App\Models\TaskComment;
use App\Observers\AttachmentObserver;
use App\Observers\ProjectObserver;
use App\Observers\TaskCommentObserver;
use App\Observers\TaskObserver;
use App\Policies\RolePolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
        Project::observe(ProjectObserver::class);
        TaskComment::observe(TaskCommentObserver::class);
        Attachment::observe(AttachmentObserver::class);

        Paginator::useBootstrapFive();
        Gate::policy(Role::class, RolePolicy::class);
        $setting = Setting::first();
        if ($setting && $setting->logo) {
            view()->share('logo', $setting->logo);
        }
    }
}
