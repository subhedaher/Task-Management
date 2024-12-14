<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Designation;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $memberId = null;

        for ($i = 0; $i < 10; $i++) {
            $departmentId = fake()->numberBetween(1, 5);

            $designationsId = Designation::where('department_id', $departmentId)->pluck('id')->toArray();

            $memberIds = Member::whereIn('designation_id', $designationsId)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Project Manager');
                })
                ->pluck('id')
                ->toArray();

            if (count($memberIds) > 0) {
                $memberId = fake()->randomElement($memberIds);
                break;
            }
        }

        return [
            'name' => fake()->name(),
            'department_id' => $departmentId,
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancled', 'overdue']),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'admin_id' => 1,
            'member_id' => $memberId
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {

            $designationsId = Designation::where('department_id', $project->department_id)->pluck('id')->toArray();

            $memberIds = Member::whereIn('designation_id', $designationsId)
                ->pluck('id')
                ->toArray();

            $countAttachments = fake()->numberBetween(1, 5);

            for ($i = 0; $i < $countAttachments; $i++) {
                $fileType = fake()->randomElement(['pdf', 'doc', 'image', 'video']);

                $uploadedBy = fake()->randomElement($memberIds);

                $attachment = new Attachment([
                    'file_name' => fake()->word() . '.' . $fileType,
                    'file_type' => $fileType,
                    'file_path' => fake()->filePath(),
                    'uploaded_by' => $uploadedBy,
                ]);

                $project->attachments()->save($attachment);
            }
        });
    }
}