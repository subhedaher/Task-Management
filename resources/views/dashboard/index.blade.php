@extends('dashboard.parent')

@section('title', __('Home'))

@section('main-title', __('Home'))

@section('page', __('home'))

@section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="row project-wrapper">
        <div class="col-md-12">
            <div class="row">
                @auth('admin')
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                            <i class="ri-list-check"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                            {{ __('Departments') }}
                                        </p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                    data-target="{{ $departments->count() }}">0</span></h4>
                                        </div>
                                        <a href="{{ route('dashboard.departments.index') }}"
                                            class="text-decoration-underline">{{ __('View details') }}</a>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                            <i class="ri-shield-user-line"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">{{ __('Members') }}
                                        </p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                    data-target="{{ $members->count() }}">0</span></h4>
                                        </div>
                                        <a href="{{ route('dashboard.members.index') }}"
                                            class="text-decoration-underline">{{ __('View details') }}</a>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                @endauth

                <div class="col-xl-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                        <i class="ri-article-line"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">{{ __('Projects') }}
                                    </p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                data-target="{{ $projects->count() }}">0</span></h4>
                                    </div>
                                    <a href="{{ route('dashboard.projects.index') }}"
                                        class="text-decoration-underline">{{ __('View details') }}</a>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                        <i class="ri-task-fill"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">{{ __('Tasks') }}
                                    </p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                data-target="{{ $tasks->count() }}">0</span></h4>
                                    </div>
                                    <a href="{{ route('dashboard.tasks.index') }}"
                                        class="text-decoration-underline">{{ __('View details') }}</a>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
            </div><!-- end row -->
        </div>
    </div>
    <div class="row">
        <div class="col-xl-7">
            <div class="card card-height-100">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title flex-grow-1 mb-0">{{ __('Active Projects') }}</h4>
                </div><!-- end cardheader -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-centered align-middle">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th scope="col">{{ __('Project Name') }}</th>
                                    <th scope="col">{{ __('Project Manager') }}</th>
                                    <th scope="col">{{ __('Progress') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col" style="width: 10%;">{{ __('End Date') }}</th>
                                </tr><!-- end tr -->
                            </thead><!-- thead -->

                            <tbody>
                                @foreach ($projects->take(5) as $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td>
                                            @if ($project->member->image)
                                                <img src="{{ Storage::url($project->member->image) }}"
                                                    class="avatar-xxs rounded-circle me-1 material-shadow" alt="">
                                            @else
                                                <img src="{{ notUserImage() }}"
                                                    class="avatar-xxs rounded-circle me-1 material-shadow" alt="">
                                            @endif
                                            <a href="javascript: void(0);"
                                                class="text-reset">{{ $project->member->name }}</a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-1 text-muted fs-13">
                                                    {{ round($project->tasks->count() > 0 ? ($project->completed_tasks_count / $project->tasks->count()) * 100 : 0) }}%
                                                </div>
                                                <div class="progress progress-sm  flex-grow-1"
                                                    style="width: {{ $project->tasks->count() > 0 ? ($project->completed_tasks_count / $project->tasks->count()) * 100 : 0 }}%;">
                                                    <div class="progress-bar bg-primary rounded" role="progressbar"
                                                        style="width: {{ $project->tasks->count() > 0 ? ($project->completed_tasks_count / $project->tasks->count()) * 100 : 0 }}%"
                                                        aria-valuenow="{{ round($project->tasks->count() > 0 ? ($project->completed_tasks_count / $project->tasks->count()) * 100 : 0) }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge {{ getStatusBadgeClass($project->status) }}">{{ $project->status }}</span>
                                        </td>
                                        <td class="text-muted">{{ dateFormate2($project->end_date) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-5">
            <div class="card card-height-100">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title flex-grow-1 mb-0">{{ __('Active tasks') }}</h4>
                </div><!-- end cardheader -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-centered align-middle">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th scope="col">{{ __('Task Name') }}</th>
                                    <th scope="col">{{ __('Project Name') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col" style="width: 10%;">{{ __('End Date') }}</th>
                                </tr><!-- end tr -->
                            </thead><!-- thead -->

                            <tbody>
                                @foreach ($tasks->take(15) as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->project->name }}</td>
                                        <td><span
                                                class="badge {{ getStatusBadgeClass($task->status) }}">{{ $task->status }}</span>
                                        </td>
                                        <td class="text-muted">{{ dateFormate2($task->end_date) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <div class="row">
        @auth('admin')
            <div class="col-xxl-4">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Team Members') }}</h4>
                    </div><!-- end card header -->

                    <div class="card-body">

                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">{{ __('Member') }}</th>
                                        <th scope="col">{{ __('Tasks') }}</th>
                                        <th scope="col">{{ __('Completed') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td class="d-flex">
                                                @if ($member->image)
                                                    <img src="{{ Storage::url($member->image) }}" alt="image"
                                                        class="avatar-xs rounded-3 me-2 material-shadow">
                                                @else
                                                    <img src="{{ notUserImage() }}" alt="image"
                                                        class="avatar-xs rounded-3 me-2 material-shadow">
                                                @endif
                                                <div>
                                                    <h5 class="fs-13 mb-0">{{ $member->name }}</h5>
                                                    <p class="fs-12 mb-0 text-muted">{{ $member->designation->name }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $member->tasks->count() }}
                                            </td>
                                            <td>
                                                {{ $member->tasks->filter(function ($task) {
                                                        return $task->status === 'completed';
                                                    })->count() }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div>
        @endauth
        @auth('member')
            <div class="col-xxl-4">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Productivities') }}</h4>
                    </div><!-- end card header -->

                    <div class="card-body">

                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">{{ __('Productivity') }}</th>
                                        <th scope="col">{{ __('Tasks') }}</th>
                                        <th scope="col">{{ __('Project') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (user()->productivities as $productivity)
                                        <tr>
                                            <td>
                                                {{ $productivity->name }}
                                            </td>
                                            <td>
                                                {{ $productivity->task->name }}
                                            </td>
                                            <td>
                                                {{ $productivity->task->project->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div>
        @endauth
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
        <div class="col-xxl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('Projects Status') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row" style="background-color: white;">
                        <div class="chart-container">
                            <canvas id="projectChart"></canvas>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('Recent Tasks Events') }}</h4>
                </div><!-- end card header -->

                <div class="card-body">

                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-nowrap align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">{{ __('Member') }}</th>
                                    <th scope="col">{{ __('Task') }}</th>
                                    <th scope="col">{{ __('Project') }}</th>
                                    <th scope="col">{{ __('Type') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks->take(5) as $task)
                                    @foreach ($task->activities as $activity)
                                        <tr>
                                            <td class="d-flex">
                                                @if ($activity->member && $activity->member->image)
                                                    <img src="{{ Storage::url($activity->member->name) }}" alt="image"
                                                        class="avatar-xs rounded-3 me-2 material-shadow">
                                                @elseif ($activity->admin && $activity->admin->image)
                                                @else
                                                    <img src="{{ notUserImage() }}" alt="image"
                                                        class="avatar-xs rounded-3 me-2 material-shadow">
                                                @endif
                                                <div>
                                                    @if ($activity->member)
                                                        <h5 class="fs-13 mb-0">{{ $activity->member->name }}</h5>
                                                        <p class="fs-12 mb-0 text-muted">
                                                            {{ $activity->member->designation->name }}</p>
                                                    @else
                                                        <h5 class="fs-13 mb-0">{{ $activity->admin->name }}</h5>
                                                        <p class="fs-12 mb-0 text-muted">
                                                            {{ $activity->admin->roles[0]->name }}</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{ $activity->task->name }}
                                            </td>
                                            <td>
                                                {{ $activity->task->project->name }}
                                            </td>
                                            <td>
                                                {{ $activity->type }}
                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
        <div class="col-xxl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('Calendar Tasks & Projects') }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="calendar"></div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        if ('{{ session('message') }}') {
            Swal.fire({
                title: "Good job!",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }

        const tasks = document.getElementById('taskChart');

        new Chart(tasks, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Completed', 'Cancled', 'Overdue'],
                datasets: [{
                    label: '# of Tasks',
                    data: [{{ $tasks->where('status', '=', 'pending')->count() }},
                        {{ $tasks->where('status', '=', 'processing')->count() }},
                        {{ $tasks->where('status', '=', 'completed')->count() }},
                        {{ $tasks->where('status', '=', 'cancled')->count() }},
                        {{ $tasks->where('status', '=', 'overdue')->count() }}
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

        const projects = document.getElementById('projectChart');

        new Chart(projects, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Completed', 'Cancled', 'Overdue'],
                datasets: [{
                    label: '# of Projects',
                    data: [{{ $projects->where('status', '=', 'pending')->count() }},
                        {{ $projects->where('status', '=', 'processing')->count() }},
                        {{ $projects->where('status', '=', 'completed')->count() }},
                        {{ $projects->where('status', '=', 'cancled')->count() }},
                        {{ $projects->where('status', '=', 'overdue')->count() }}
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

        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            var tasks = @json($tasks) || [];
            var projects = @json($projects) || [];

            function isValidDate(dateString) {
                var date = new Date(dateString);
                return !isNaN(date.getTime());
            }

            var taskEvents = tasks.map(function(task) {
                return {
                    title: task.name,
                    start: isValidDate(task.start_date) ? task.start_date : null,
                    end: isValidDate(task.end_date) ? task.end_date : null
                };
            }).filter(event => event.start !== null);

            var projectEvents = projects.map(function(project) {
                return {
                    title: project.name,
                    start: isValidDate(project.start_date) ? project.start_date : null,
                    end: isValidDate(project.end_date) ? project.end_date : null
                };
            }).filter(event => event.start !== null);

            var events = taskEvents.concat(projectEvents);

            var initialDate;
            if (events.length > 0) {
                var allDates = events.map(event => new Date(event.start));
                initialDate = new Date(Math.min.apply(null, allDates));
            } else {
                initialDate = new Date();
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: initialDate.toISOString().split('T')[0],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events,
            });

            calendar.render();
        });
    </script>
@endsection
