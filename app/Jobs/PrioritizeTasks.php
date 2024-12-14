<?php

namespace App\Jobs;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrioritizeTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $tasks = Task::whereNotIn('status', ['completed', 'canceled'])
            ->where('priority', '!=', 'high')
            ->get();

        foreach ($tasks as $task) {
            $priority = $this->calculatePriority($task);
            $task->update(['priority' => $priority]);
        }
    }

    private function calculatePriority($task)
    {
        $end_date = Carbon::parse($task->end_date);
        $today = Carbon::now();
        $daysRemaining = $end_date->diffInDays($today);
        if ($daysRemaining <= 3) {
            return 'high';
        } elseif ($daysRemaining <= 7) {
            return 'medium';
        } else {
            return 'low';
        }
    }
}
