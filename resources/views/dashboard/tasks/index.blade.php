@extends('dashboard.parent')

@section('title', __('Tasks'))

@section('main-title', __('Tasks'))

@section('page', __('List Tasks'))

@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">{{ __('Total Tasks') }}</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="{{ $tasksAll->count() }}">0</span>
                            </h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                    <i class="ri-ticket-2-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">{{ __('Pending Tasks') }}</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="{{ $tasksAll->where('status', '=', 'pending')->count() }}">0</span></h2>

                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                    <i class="mdi mdi-timer-sand"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">{{ __('Completed Tasks') }}</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="{{ $tasksAll->where('status', '=', 'completed')->count() }}">0</span></h2>

                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                    <i class="ri-checkbox-circle-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-3 col-sm-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">{{ __('Overdue Tasks') }}</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="{{ $tasksAll->where('status', '=', 'overdue')->count() }}">0</span></h2>

                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                                    <i class="ri-time-line"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">{{ __('All Tasks') }}</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-12">
                                <div class="search-box">
                                    <input type="text" class="form-control search bg-light border-light"
                                        placeholder="Search for tasks or something...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-3 col-sm-4">
                                <div class="input-light">
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="choices-single-default" id="idStatus">
                                        <option value=""></option>
                                        <option value="*">{{ __('All') }}</option>
                                        @foreach ($statuses as $K => $statuse)
                                            <option value="{{ $K }}">{{ $statuse }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <button type="button" class="btn btn-primary w-100"> <i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ __('Filters') }}
                                </button>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="sort" data-sort="id">{{ __('Task') }}</th>
                                    <th class="sort" data-sort="project_name">{{ __('Project') }}</th>
                                    <th class="sort" data-sort="tasks_name">{{ __('Status') }}</th>
                                    <th class="sort" data-sort="client_name">{{ __('Priority') }}</th>
                                    <th class="sort" data-sort="assignedto">{{ __('Assigned To') }}</th>
                                    <th class="sort" data-sort="due_date">{{ __('Start Date') }}</th>
                                    <th class="sort" data-sort="status">{{ __('End Date') }}</th>
                                    <th class="sort" data-sort="priority">{{ __('Created At') }}</th>
                                    <th class="sort" data-sort="priority">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td class="id"><a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                                class="fw-medium link-primary">{{ $task->name }}</a></td>
                                        <td class="project_name"><a
                                                href="{{ route('dashboard.projects.show', $task->project->id) }}"
                                                class="fw-medium link-primary">{{ $task->project->name }}</a></td>
                                        <td class="status"><span
                                                class="badge {{ getStatusBadgeClass($task->status) }} text-uppercase">{{ $task->status }}</span>
                                        </td>
                                        <td class="priority"><span
                                                class="badge {{ getPriorityBadgeClass($task->priority) }} text-uppercase">{{ $task->priority }}</span>
                                        </td>
                                        <td class="assignedto">
                                            <div class="avatar-group">
                                                @foreach ($task->members as $member)
                                                    @if ($member->image)
                                                        <a href="javascript:void(0);" class="avatar-stack-item"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="{{ $member->name }}">
                                                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                                                alt="{{ $member->name }}"
                                                                class="rounded-circle avatar-xxs" />
                                                        </a>
                                                    @else
                                                        <img src="{{ notUserImage() }}" alt="{{ $member->name }}"
                                                            class="rounded-circle avatar-xxs avatar-stack-item" />
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="due_date">{{ dateFormate2($task->start_date) }}</td>
                                        <td class="due_date">{{ dateFormate2($task->end_date) }}</td>
                                        <td class="due_date">{{ dateFormate2($task->created_at) }}</td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                                    <li><a href="{{ route('dashboard.tasks.show', $task->id) }}"
                                                            class="dropdown-item edit-item-btn"><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            {{ __('Show') }}</a></li>
                                                    <li><a href="{{ route('dashboard.tasks.edit', $task->id) }}"
                                                            class="dropdown-item edit-item-btn"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            {{ __('Edit') }}</a></li>
                                                    <li>
                                                        <form id="button-delete-{{ $task->id }}"
                                                            action="{{ route('dashboard.tasks.destroy', $task->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end table-->
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 200k+ tasks We did
                                    not find any tasks for you search.</p>
                            </div>
                        </div>
                    </div>
                    {{ $tasks->links() }}
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets') }}/libs/list.js/list.min.js"></script>
    <script src="{{ asset('assets') }}/libs/list.pagination.js/list.pagination.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/tasks-list.init.js"></script>
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
