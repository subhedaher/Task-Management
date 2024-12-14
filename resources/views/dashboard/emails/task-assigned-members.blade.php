<x-mail::message>
<img src="{{ $imageUrl }}" alt="Logo" style="max-width: 15%; height: auto;"/><br>
# New Task Assignment

Dear **{{ $memberName }}**,

A new task has been created in the project **{{ $projectName }}**.

**Task Name:** {{ $taskName }}<br>
**Priority:** {{ $taskPirority }}<br>
**Start Date:** {{ $startDate }}<br>
**Expected End Date:** {{ $endDate }}<br>

**Description:**

{{ $taskDescription }}

**Thanks,**<br>
**{{ $adminName }}**<br>
**{{ $position }}**<br>
**{{ env('APP_NAME') }}**
</x-mail::message>
