<x-mail::message>
<img src="{{ $imageUrl }}" alt="Logo" style="max-width: 15%; height: auto;"/><br>
# New Project Invitation

Dear **{{ $memberName }}**,

We are excited to inform you about a new project that has been created under your department:

**Project Name:** {{ $projectName }}
**Project Description:** {{ $projectDescription }}
**Start Date:** {{ $startDate }}
**Expected End Date:** {{ $endDate }}

## Project Details

- **Project Manager:** {{ $projectManager }}
- **Department:** {{ $departmentName }}

## What You Need to Do

- **Review the Project:** Please review the project details and objectives.
- **Confirm Participation:** Click the button below to confirm your participation and get started.
- **Provide Feedback:** Let us know if you have any questions or feedback about the project.

Thank you for your attention and cooperation. We look forward to your valuable contributions to this project.

If you have any questions, feel free to reach out.

**Best regards,**<br>
**{{ $adminName }}**<br>
**{{ $position }}**<br>
**{{ env('APP_NAME') }}**
</x-mail::message>
