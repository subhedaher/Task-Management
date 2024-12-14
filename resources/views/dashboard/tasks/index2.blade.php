@extends('dashboard.parent')

@section('title', __('Tasks'))

@section('main-title', __('Tasks'))

@section('page', __('List Tasks'))

@php
    use Illuminate\Support\Str;
@endphp

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
        <div class="col">
            <div class="card">
                <a class="card-body bg-danger-subtle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#pendingTask" role="button" aria-expanded="false"
                    aria-controls="pendingTask">
                    <div class="me-3">
                        <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{ __('Pending Tasks') }}</h5>
                        <p class="text-muted mb-0">{{ $tasks->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="icon-container text-center">
                        <i class="ri-time-line" style="font-size: 30px; color: #dc3545;"></i>
                        <!-- Use the clock icon for pending tasks -->
                    </div>
                </a>
            </div>
            <!--end card-->
            <div class="collapse show" id="pendingTask">
                @foreach ($tasks->where('status', 'pending') as $task)
                    <div class="card mb-3"> <!-- Adjusted margin bottom for spacing between cards -->
                        <div class="card-body">
                            <a class="d-flex align-items-center text-decoration-none" data-bs-toggle="collapse"
                                href="#task-{{ $task->id }}" role="button" aria-expanded="false"
                                aria-controls="task-{{ $task->id }}">
                                <div class="flex-shrink-0">
                                    <i class="ri-task-fill text-primary" style="font-size: 25px;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-16 fw-semibold mb-0">{{ $task->name }}</h6>
                                    <!-- Increased font size and made it bold -->
                                    <p class="text-muted mb-0">{{ $task->project->name }}</p>
                                </div>
                                <div class="ms-auto">
                                    <span
                                        class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                                </div>
                            </a>
                        </div>

                        <div class="collapse border-top border-top-dashed" id="task-{{ $task->id }}">
                            <div class="card-body">
                                <h6 class="fs-14 mb-3"> <!-- Increased margin bottom for better spacing -->
                                    <strong>{{ __('Description') }}:</strong>
                                    <span class="text-muted">{{ Str::limit($task->description, 100) }}</span>
                                </h6>
                                <div class="mb-2">
                                    <strong>{{ __('Start Date') }}:</strong>
                                    <span
                                        class="text-primary">{{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('End Date') }}:</strong>
                                    <span
                                        class="text-danger">{{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Priority') }}:</strong>
                                    <span
                                        class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Assigned To') }}:</strong>
                                    <br>
                                    @foreach ($task->members as $member)
                                        <span class="text-muted">
                                            @auth('admin')
                                                <a
                                                    href="{{ route('dashboard.members.show', $member->id) }}">{{ $member->name }}</a>
                                            @endauth
                                            @auth('member')
                                                <span>{{ $member->name }}</span>
                                            @endauth
                                        </span>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer hstack gap-2">
                                <a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                    class="btn btn-success btn-sm w-90"> <!-- Adjusted width for buttons -->
                                    <i class="ri-eye-fill align-bottom me-1"></i> {{ __('Show') }}
                                </a>
                                @auth('admin')
                                    <a href="{{ route('dashboard.tasks.edit', $task->id) }}" class="btn btn-info btn-sm w-90">
                                        <i class="ri-pencil-fill align-bottom me-1"></i> {{ __('Edit') }}
                                    </a>
                                    <form id="button-delete-{{ $task->id }}"
                                        action="{{ route('dashboard.tasks.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-90">
                                            <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="card">
                <a class="card-body bg-info-subtle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#processingTasks" role="button" aria-expanded="false"
                    aria-controls="processingTasks">
                    <div class="me-3">
                        <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{ __('Processing Tasks') }}</h5>
                        <p class="text-muted mb-0">{{ $tasks->where('status', 'processing')->count() }}
                        </p>
                    </div>
                    <div class="icon-container text-center">
                        <i class="ri-loader-2-line" style="font-size: 30px; color: #0dcaf0;"></i> <!-- Loader icon -->
                    </div>
                </a>
            </div>
            <!--end card-->
            <div class="collapse show" id="processingTasks">
                @foreach ($tasks->where('status', 'processing') as $task)
                    <div class="card mb-3"> <!-- Adjusted margin bottom for spacing between cards -->
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse" href="#task-{{ $task->id }}"
                                role="button" aria-expanded="false" aria-controls="task-{{ $task->id }}">
                                <div class="flex-shrink-0">
                                    <i class="ri-task-fill" style="font-size: 25px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $task->name }}</h6>
                                    <p class="text-muted mb-0">{{ $task->project->name }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="collapse border-top border-top-dashed" id="task-{{ $task->id }}">
                            <div class="card-body">
                                <h6 class="fs-14 mb-3"> <!-- Increased margin bottom for better spacing -->
                                    <strong>{{ __('Description') }}:</strong> <span
                                        class="text-muted">{{ Str::limit($task->description, 20) }}</span>

                                </h6>
                                <div class="mb-2">
                                    <strong>{{ __('Start Date') }}:</strong>
                                    <span
                                        class="text-primary">{{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('End Date') }}:</strong>
                                    <span
                                        class="text-danger">{{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Priority') }}:</strong>
                                    <span
                                        class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Assigned To') }}:</strong>
                                    <br>
                                    @foreach ($task->members as $member)
                                        <span class="text-muted">
                                            <a
                                                href="{{ route('dashboard.members.show', $member->id) }}">{{ $member->name }}</a>
                                        </span>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer hstack gap-2">
                                <a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                    class="btn btn-success btn-sm w-90"> <!-- Adjusted width for buttons -->
                                    <i class="ri-eye-fill align-bottom me-1"></i> {{ __('Show') }}
                                </a>
                                @auth('admin')
                                    <a href="{{ route('dashboard.tasks.edit', $task->id) }}"
                                        class="btn btn-info btn-sm w-90">
                                        <i class="ri-pencil-fill align-bottom me-1"></i> {{ __('Edit') }}
                                    </a>
                                    <form id="button-delete-{{ $task->id }}"
                                        action="{{ route('dashboard.tasks.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-90">
                                            <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--end card-->
            </div>
        </div>
        <!--end col-->

        <div class="col">
            <div class="card">
                <a class="card-body bg-success-subtle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#completedTasks" role="button" aria-expanded="false"
                    aria-controls="completedTasks">
                    <div>
                        <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{ __('Completed Tasks') }}</h5>
                        <p class="text-muted mb-0">{{ $tasks->where('status', 'completed')->count() }}
                        </p>
                    </div>
                    <div class="icon-container text-center me-3">
                        <i class="ri-check-line" style="font-size: 30px; color: #28a745;"></i>
                    </div>
                </a>
            </div>
            <!--end card-->
            <div class="collapse show" id="completedTasks">
                @foreach ($tasks->where('status', 'completed') as $task)
                    <div class="card mb-3"> <!-- Adjusted margin bottom for spacing between cards -->
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                href="#task-{{ $task->id }}" role="button" aria-expanded="false"
                                aria-controls="task-{{ $task->id }}">
                                <div class="flex-shrink-0">
                                    <i class="ri-task-fill" style="font-size: 25px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $task->name }}</h6>
                                    <p class="text-muted mb-0">{{ $task->project->name }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="collapse border-top border-top-dashed" id="task-{{ $task->id }}">
                            <div class="card-body">
                                <h6 class="fs-14 mb-3"> <!-- Increased margin bottom for better spacing -->
                                    <strong>{{ __('Description') }}:</strong> <span
                                        class="text-muted">{{ Str::limit($task->description, 100) }}</span>
                                </h6>
                                <div class="mb-2">
                                    <strong>{{ __('Start Date') }}:</strong>
                                    <span
                                        class="text-primary">{{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('End Date') }}:</strong>
                                    <span
                                        class="text-danger">{{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Priority') }}:</strong>
                                    <span
                                        class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Assigned To') }}:</strong>
                                    <br>
                                    @foreach ($task->members as $member)
                                        <span class="text-muted">
                                            <a
                                                href="{{ route('dashboard.members.show', $member->id) }}">{{ $member->name }}</a>
                                        </span>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer hstack gap-2">
                                <a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                    class="btn btn-success btn-sm w-90"> <!-- Adjusted width for buttons -->
                                    <i class="ri-eye-fill align-bottom me-1"></i> {{ __('Show') }}
                                </a>
                                <a href="{{ route('dashboard.tasks.edit', $task->id) }}"
                                    class="btn btn-info btn-sm w-90">
                                    <i class="ri-pencil-fill align-bottom me-1"></i> {{ __('Edit') }}
                                </a>
                                <form id="button-delete-{{ $task->id }}"
                                    action="{{ route('dashboard.tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-90">
                                        <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--end card-->
            </div>
        </div>
        <!--end col-->

        <div class="col">
            <div class="card">
                <a class="card-body bg-warning-subtle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#cancledTask" role="button" aria-expanded="false"
                    aria-controls="cancledTask">
                    <div class="me-3">
                        <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{ __('cancled Tasks') }}</h5>
                        <p class="text-muted mb-0">{{ $tasks->where('status', 'cancled')->count() }}
                        </p>
                    </div>
                    <div class="icon-container text-center me-3">
                        <i class="ri-close-line" style="font-size: 30px; color: #ffc107;"></i>
                    </div>
                </a>
            </div>
            <!--end card-->
            <div class="collapse show" id="cancledTask">
                @foreach ($tasks->where('status', 'cancled') as $task)
                    <div class="card mb-3"> <!-- Adjusted margin bottom for spacing between cards -->
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                href="#task-{{ $task->id }}" role="button" aria-expanded="false"
                                aria-controls="task-{{ $task->id }}">
                                <div class="flex-shrink-0">
                                    <i class="ri-task-fill" style="font-size: 25px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $task->name }}</h6>
                                    <p class="text-muted mb-0">{{ $task->project->name }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="collapse border-top border-top-dashed" id="task-{{ $task->id }}">
                            <div class="card-body">
                                <h6 class="fs-14 mb-3"> <!-- Increased margin bottom for better spacing -->
                                    <strong>{{ __('Description') }}:</strong> <span
                                        class="text-muted">{{ Str::limit($task->description, 100) }}</span>

                                </h6>
                                <div class="mb-2">
                                    <strong>{{ __('Start Date') }}:</strong>
                                    <span
                                        class="text-primary">{{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('End Date') }}:</strong>
                                    <span
                                        class="text-danger">{{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Priority') }}:</strong>
                                    <span
                                        class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Assigned To') }}:</strong>
                                    <br>
                                    @foreach ($task->members as $member)
                                        <span class="text-muted">
                                            <a
                                                href="{{ route('dashboard.members.show', $member->id) }}">{{ $member->name }}</a>
                                        </span>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer hstack gap-2">
                                <a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                    class="btn btn-success btn-sm w-90"> <!-- Adjusted width for buttons -->
                                    <i class="ri-eye-fill align-bottom me-1"></i> {{ __('Show') }}
                                </a>
                                <a href="{{ route('dashboard.tasks.edit', $task->id) }}"
                                    class="btn btn-info btn-sm w-90">
                                    <i class="ri-pencil-fill align-bottom me-1"></i> {{ __('Edit') }}
                                </a>
                                <form id="button-delete-{{ $task->id }}"
                                    action="{{ route('dashboard.tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-90">
                                        <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="card">
                <a class="card-body bg-danger-subtle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#overdueTask" role="button" aria-expanded="false"
                    aria-controls="overdueTask">
                    <div class="me-3">
                        <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{ __('Overdue Task') }}</h5>
                        <p class="text-muted mb-0">{{ $tasks->where('status', 'overdue')->count() }}
                        </p>
                    </div>
                    <div class="icon-container text-center me-3">
                        <i class="ri-alert-fill" style="font-size: 30px; color: #dc3545;"></i>
                    </div>

                </a>
            </div>
            <!--end card-->
            <div class="collapse show" id="overdueTask">
                @foreach ($tasks->where('status', 'overdue') as $task)
                    <div class="card mb-3"> <!-- Adjusted margin bottom for spacing between cards -->
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                href="#task-{{ $task->id }}" role="button" aria-expanded="false"
                                aria-controls="task-{{ $task->id }}">
                                <div class="flex-shrink-0">
                                    <i class="ri-task-fill" style="font-size: 25px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $task->name }}</h6>
                                    <p class="text-muted mb-0">{{ $task->project->name }}</p>
                                </div>
                            </a>
                        </div>

                        <div class="collapse border-top border-top-dashed" id="task-{{ $task->id }}">
                            <div class="card-body">
                                <h6 class="fs-14 mb-3"> <!-- Increased margin bottom for better spacing -->
                                    <strong>{{ __('Description') }}:</strong> <span
                                        class="text-muted">{{ Str::limit($task->description, 100) }}</span>

                                </h6>
                                <div class="mb-2">
                                    <strong>{{ __('Start Date') }}:</strong>
                                    <span
                                        class="text-primary">{{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('End Date') }}:</strong>
                                    <span
                                        class="text-danger">{{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Priority') }}:</strong>
                                    <span
                                        class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>{{ __('Assigned To') }}:</strong>
                                    <br>
                                    @foreach ($task->members as $member)
                                        <span class="text-muted">
                                            <a
                                                href="{{ route('dashboard.members.show', $member->id) }}">{{ $member->name }}</a>
                                        </span>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer hstack gap-2">
                                <a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                    class="btn btn-success btn-sm w-90"> <!-- Adjusted width for buttons -->
                                    <i class="ri-eye-fill align-bottom me-1"></i> {{ __('Show') }}
                                </a>
                                <a href="{{ route('dashboard.tasks.edit', $task->id) }}"
                                    class="btn btn-info btn-sm w-90">
                                    <i class="ri-pencil-fill align-bottom me-1"></i> {{ __('Edit') }}
                                </a>
                                <form id="button-delete-{{ $task->id }}"
                                    action="{{ route('dashboard.tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-90">
                                        <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--end card-->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('scripts')
    <script src="{{ asset('assets') }}/js/pages/select2.init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let s = document.querySelectorAll('form[id^="button-delete-"]').forEach((form) => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        if ('{{ session('message') }}') {
            Swal.fire({
                title: "Good job!",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }
    </script>
@endsection
