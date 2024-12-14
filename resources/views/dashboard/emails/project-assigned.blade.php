<x-mail::message>
<img src="{{ $imageUrl }}" alt="Logo" style="max-width: 15%; height: auto;"/><br>
# Project Manager Assignment

Dear **{{ $managerName }}**,

We are pleased to inform you that you have been appointed as the Project Manager for the following project:

**Project Name:** {{ $projectName }}<br>
**Start Date:** {{ $startDate }}<br>
**Expected End Date:** {{ $endDate }}<br>

## Responsibilities:

- Lead the project team and guide them towards achieving project goals.
- Monitor project progress and ensure objectives are met on time.
- Coordinate with stakeholders and provide regular updates on project status.
- Manage resources and resolve any issues that may arise during the project execution.

## Next Steps:

- Please review the project details in our management system.
- Schedule a meeting with the team to discuss the project plan.
- Inform us of any additional support or resources you may need.

We are confident that you will be an excellent leader for this project, and we look forward to seeing your success in this new role.

If you have any questions or need further information, please do not hesitate to reach out.

**Thanks,**<br>
**{{ $adminName }}**<br>
**{{ $position }}**<br>
**{{ env('APP_NAME') }}**
</x-mail::message>
