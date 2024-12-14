@extends('dashboard.parent')

@section('title', __('Reports'))

@section('main-title', __('Reports'))

@section('page', __('Project'))

@section('content')
    <div class="card-header d-flex align-items-center mb-4">
        <h1 class="card-title mb-0 flex-grow-1 text-danger">{{ __('Project Details') }}</h1>
        <a href="{{ route('dashboard.project.pdf', $project->id) }}" id="downloadPdfBtn" class="btn btn-primary">
            <i class="ri-file-pdf-line"></i> {{ __('Download PDF') }}
        </a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ $project->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Start Date') }}:</strong>
                            {{ dateFormate2($project->start_date) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('End Date') }}:</strong>
                            {{ dateFormate2($project->end_date) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Department') }}:</strong>
                            @foreach ($project->departments as $department)
                                {{ $department->name . ' ' }}
                            @endforeach
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Project Manager') }}:</strong>
                            {{ $project->member->name }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Status') }}:</strong>
                            <span class="badge {{ getStatusBadgeClass($project->status) }}">{{ $project->status }}</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Priority') }}:</strong>
                            <span
                                class="badge {{ getPriorityBadgeClass($project->priority) }}">{{ $project->priority }}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>{{ __('Description') }}:</strong>
                            <p class="text-muted">{{ $project->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Tasks') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Task Name: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Task Name') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Status: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Status') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Priority: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Priority') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Start Date: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Start Date') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="End Date: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('End Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td><span
                                            class="badge {{ getStatusBadgeClass($task->status) }}">{{ $task->status }}</span>
                                    </td>
                                    <td><span
                                            class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ $task->priority }}</span>
                                    </td>
                                    <td>{{ $task->start_date }}</td>
                                    <td>{{ $task->end_date }}</td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Members') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Task Name: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Memebr Name') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Designation: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('Designation') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->designation->name }}</td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Attachments') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="File Name: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('File Name') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="File Type: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('File Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $attachment)
                                <tr>
                                    <td>{{ $attachment->file_name }}</td>
                                    <td>{{ $attachment->file_type }}</td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('Tasks Status') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row" style="background-color: white;">
                        <div class="chart-container">
                            <canvas id="taskChart"></canvas>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        const tasks = document.getElementById('taskChart');
        new Chart(tasks, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Completed', 'Cancled', 'Overdue'],
                datasets: [{
                    label: '# of Tasks',
                    data: [{{ $project->tasks->where('status', '=', 'pending')->count() }},
                        {{ $project->tasks->where('status', '=', 'processing')->count() }},
                        {{ $project->tasks->where('status', '=', 'completed')->count() }},
                        {{ $project->tasks->where('status', '=', 'cancled')->count() }},
                        {{ $project->tasks->where('status', '=', 'overdue')->count() }}
                    ],
                    backgroundColor: [
                        'rgb(255, 193, 7)',
                        'rgb(0, 123, 255)',
                        'rgb(40, 167, 69)',
                        'rgb(220, 53, 69)',
                        'rgb(255, 87, 34)'
                    ],
                    borderWidth: 2
                }]
            },
        });
    </script>
@endsection
