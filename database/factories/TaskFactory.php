<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Designation;
use App\Models\Member;
use App\Models\Productivity;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(2),
            'project_id' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancled', 'overdue']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'completed_at' => fake()->dateTime()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            $departmentId = $task->project->department->id;

            $designationsId = Designation::where('department_id', '=', $departmentId)->pluck('id')->toArray();

            $memberIds = Member::whereIn('designation_id', $designationsId)
                ->pluck('id')
                ->toArray();

            if (count($memberIds) > 0) {
                $randomCount = fake()->numberBetween(1, 5);
                $randomCount = min($randomCount, count($memberIds));

                $selectedMemberIds = fake()->randomElements($memberIds, $randomCount);

                foreach ($selectedMemberIds as $memberId) {
                    $taskMember = TaskMember::create([
                        'task_id' => $task->id,
                        'member_id' => $memberId,
                    ]);

                    for ($i = 0; $i < 50; $i++) {
                        TaskComment::create([
                            'task_id' => $task->id,
                            'member_id' => $taskMember->member_id,
                            'comment' => fake()->sentence(),
                        ]);
                    }

                    for ($i = 0; $i < 5; $i++) {
                        Productivity::create([
                            'name' => fake()->name(),
                            'task_id' => $task->id,
                            'member_id' => $taskMember->member_id,
                            'description' => fake()->sentence(),
                            'start' => fake()->dateTime(),
                            'end' => fake()->dateTime(),
                        ]);
                    }

                    $countAttachments = fake()->numberBetween(1, 5);

                    for ($i = 0; $i < $countAttachments; $i++) {
                        $fileType = fake()->randomElement(['pdf', 'doc', 'image', 'video']);
                        $attachment = new Attachment([
                            'file_name' => fake()->word() . '.' . $fileType,
                            'file_type' => $fileType,
                            'file_path' => fake()->filePath(),
                            'uploaded_by' => $taskMember->member_id,
                        ]);

                        $task->attachments()->save($attachment);
                    }
                }
            }
        });
    }
}