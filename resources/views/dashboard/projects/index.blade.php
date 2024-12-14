@extends('dashboard.parent')

@section('title', __('Projects'))

@section('main-title', __('Projects'))

@section('page', __('List Projects'))

@section('style')
    <style></style>
@endsection

@section('content')
    <div class="row g-4 mb-3">
        @auth('admin')
            <div class="col-sm-auto">
                <div>
                    <a href="{{ route('dashboard.projects.create') }}" class="btn btn-success"><i
                            class="ri-add-line align-bottom me-1"></i>{{ __('Add New') }}</a>
                </div>
            </div>
        @endauth
        <div class="col-sm">
            <div class="d-flex justify-content-sm-end gap-2">
                <div class="search-box ms-2">
                    <input type="text" id="search" class="form-control" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="projectsAll">
        @foreach ($projects as $project)
            <div class="col-xxl-3 col-sm-6 project-card">
                <div class="card card-height-100">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-4">
                                        {{ __('Last Updated') . ' ' . dateFormate($project->updated_at) }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="d-flex gap-1 align-items-center">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15 material-shadow-none"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-horizontal icon-sm">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('dashboard.projects.show', $project->id) }}"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    {{ __('View') }}</a>
                                                @auth('admin')
                                                    <a class="dropdown-item"
                                                        href="{{ route('dashboard.projects.edit', $project->id) }}"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        {{ __('Edit') }}</a>
                                                    <div class="dropdown-divider"></div>
                                                    <li>
                                                        <form id="button-delete-{{ $project->id }}"
                                                            action="{{ route('dashboard.projects.destroy', $project->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-warning-subtle rounded p-2">
                                            <i class="ri-todo-fill" style="color: #405189;font-size:25px"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fs-15"><a href="{{ route('dashboard.projects.show', $project->id) }}"
                                            class="text-body">{{ $project->name }}</a></h5>
                                    <p class="text-muted text-truncate-two-lines mb-3">{{ $project->description }}</p>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <div>
                                        <p class="text-muted mb-1">{{ __('Status') }}</p>
                                        <div class="badge {{ getStatusBadgeClass($project->status) }} fs-12">
                                            {{ $project->status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <p class="text-muted mb-1">{{ __('Priority') }}</p>
                                        <h5 class="badge {{ getPriorityBadgeClass($project->priority) }}">
                                            {{ $project->priority }}
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex mb-2">
                                    <div class="flex-grow-1">
                                        <div>{{ __('Tasks') }}</div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div><i class="ri-list-check align-bottom me-1 text-muted"></i>
                                            {{ $project->completed_tasks_count }}/{{ $project->tasks_count }}</div>
                                    </div>
                                </div>
                                <div class="progress progress-sm animated-progress">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        aria-valuenow="{{ $project->tasks_count > 0 ? ($project->completed_tasks_count / $project->tasks_count) * 100 : 0 }}"
                                        aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $project->tasks_count > 0 ? ($project->completed_tasks_count / $project->tasks_count) * 100 : 0 }}%;">
                                    </div>
                                </div><!-- /.progress -->
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                    <div class="card-footer bg-transparent border-top-dashed py-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted">
                                    {{ $project->member->name }}
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="text-muted">
                                    <i class="ri-calendar-event-fill me-1 align-bottom"></i>
                                    {{ dateFormate2($project->end_date) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card footer -->
                </div>
                <!-- end card -->
            </div>
        @endforeach
        {{ $projects->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('form[id^="button-delete-"]').forEach((form) => {
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
