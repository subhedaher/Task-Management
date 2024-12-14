@extends('dashboard.parent')

@section('title', __('Projects'))

@section('main-title', __('Projects'))

@section('page', __('Show Project'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-n4 mx-n4">
                    <div class="bg-warning-subtle">
                        <div class="card-body pb-0 px-4">
                            <div class="row mb-3">
                                <div class="col-md">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-auto">
                                            <div class="avatar-md">
                                                <div class="avatar-title bg-white rounded-circle">
                                                    <i class="ri-todo-fill" style="color: #405189;font-size:35px"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div>
                                                <h4 class="fw-bold">{{ $project->name }}</h4>
                                                <div class="hstack gap-3 flex-wrap">
                                                    @foreach ($project->departments as $department)
                                                        <div><i class="ri-list-check me-1"></i> {{ $department->name }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#project-overview"
                                        role="tab" aria-selected="false" tabindex="-1">
                                        {{ __('Overview') }}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-documents"
                                        role="tab" aria-selected="false" tabindex="-1">
                                        {{ __('Attachments') }}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-team" role="tab"
                                        aria-selected="true">
                                        {{ __('Members') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content text-muted">
                    <div class="tab-pane fade active show" id="project-overview" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-9 col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-muted">
                                            <h6 class="mb-3 fw-semibold text-uppercase">{{ __('Description') }}</h6>
                                            <p>{{ $project->description }}</p>
                                            <div class="pt-3 border-top border-top-dashed mt-4">
                                                <div class="row gy-3">

                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">{{ __('Create At') }}:
                                                            </p>
                                                            <h5 class="fs-15 mb-0">{{ dateFormate2($project->created_at) }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">{{ __('Create By') }}:
                                                            </p>
                                                            <h5 class="fs-15 mb-0">{{ $project->admin->name ?? '-' }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">
                                                                {{ __('Start Date') }}:
                                                            </p>
                                                            <h5 class="fs-15 mb-0">{{ dateFormate2($project->srart_date) }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">{{ __('End Date') }}:
                                                            </p>
                                                            <h5 class="fs-15 mb-0">{{ dateFormate2($project->end_date) }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">{{ __('Priority') }}:
                                                            </p>
                                                            <div
                                                                class="badge {{ getPriorityBadgeClass($project->priority) }} fs-12">
                                                                {{ $project->priority }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">{{ __('Status') }}:
                                                            </p>
                                                            <div
                                                                class="badge {{ getStatusBadgeClass($project->status) }} fs-12">
                                                                {{ $project->status }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 mt-5">
                                                        <div>
                                                            <p class="mb-2 text-uppercase fw-medium">
                                                                {{ __('Project Manager') }}:
                                                            </p>
                                                            <h5 class="fs-15 mb-0">{{ $project->member->name }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- ene col -->
                            <div class="col-xl-3 col-lg-4">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex border-bottom-dashed">
                                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Members') }}</h4>

                                    </div>
                                    <div class="card-body">
                                        <div data-simplebar="init" style="height: 235px;" class="mx-n3 px-3">
                                            <div class="simplebar-wrapper" style="margin: 0px -16px;">
                                                <div class="simplebar-height-auto-observer-wrapper">
                                                    <div class="simplebar-height-auto-observer"></div>
                                                </div>
                                                <div class="simplebar-mask">
                                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                                            aria-label="scrollable content"
                                                            style="height: auto; overflow: hidden;">
                                                            <div class="simplebar-content" style="padding: 0px 16px;">
                                                                <div class="vstack gap-3">
                                                                    @php
                                                                        $members = $project->tasks
                                                                            ->flatMap(function ($task) {
                                                                                return $task->members;
                                                                            })
                                                                            ->unique('id');
                                                                    @endphp
                                                                    @foreach ($members as $member)
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                                                @if ($member->image)
                                                                                    <img src="{{ Storage::url($member->image) }}"
                                                                                        alt="image"
                                                                                        class="img-fluid rounded-circle">
                                                                                @endif
                                                                                <img src="{{ notUserImage() }}"
                                                                                    alt="image"
                                                                                    class="img-fluid rounded-circle">
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <h5 class="fs-13 mb-0">
                                                                                    @auth('admin')
                                                                                        <a href="{{ route('dashboard.members.show', $member->id) }}"
                                                                                            class="text-body d-block">{{ $member->name }}</a>
                                                                                    @endauth
                                                                                    @auth('member')
                                                                                        <span
                                                                                            class="text-body d-block">{{ $member->name }}</span>
                                                                                    @endauth
                                                                                </h5>
                                                                            </div>
                                                                            <div class="flex-shrink-0">
                                                                                <div
                                                                                    class="d-flex align-items-center gap-1">
                                                                                    <button type="button"
                                                                                        class="btn btn-light btn-sm material-shadow-none">{{ __('Message') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <!-- end list -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                                            </div>
                                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                            </div>
                                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                                <div class="simplebar-scrollbar"
                                                    style="height: 0px; transform: translate3d(0px, 0px, 0px); display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                <div class="card">
                                    <div class="card-header align-items-center d-flex border-bottom-dashed">
                                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Attachments') }}</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="vstack gap-2">
                                            @foreach ($project->attachments as $attachment)
                                                <div class="border rounded border-dashed p-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-sm">
                                                                <div
                                                                    class="avatar-title bg-light text-secondary rounded fs-24">
                                                                    <i class="ri-folder-zip-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="fs-13 mb-1"><a href="#"
                                                                    class="text-body text-truncate d-block">{{ $attachment->file_name }}</a>
                                                            </h5>
                                                            <div>
                                                                {{ Storage::has($attachment->file_path) ? $attachment->file_type : '-' }}
                                                            </div>

                                                            <div>
                                                                {{ Storage::has($attachment->file_path) ? formatFileSize(Storage::Size($attachment->file_path)) : '-' }}
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-2">
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('dashboard.attachments.show', $attachment->id) }}"
                                                                    type="button"
                                                                    class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none"><i
                                                                        class="ri-download-2-line"></i></a>
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-icon text-muted btn-sm fs-18 dropdown material-shadow-none"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="ri-more-fill"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('dashboard.view', $attachment->id) }}"><i
                                                                                    class="ri-eye-fill me-2 align-bottom text-muted"></i>{{ __('View') }}</a>
                                                                        </li>
                                                                        @auth('admin')
                                                                            <form id="button-delete-{{ $attachment->id }}"
                                                                                action="{{ route('dashboard.attachments.destroy', $attachment->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="dropdown-item">
                                                                                    <i class="bx bx-trash me-1"></i>
                                                                                    {{ __('Delete') }}
                                                                                </button>
                                                                            </form>
                                                                        @endauth
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane fade" id="project-documents" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <h5 class="card-title flex-grow-1">{{ __('Attachments') }}</h5>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive table-card">
                                            <table class="table table-borderless align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">{{ __('File Name') }}</th>
                                                        <th scope="col">{{ __('Type') }}</th>
                                                        <th scope="col">{{ __('Size') }}</th>
                                                        <th scope="col">{{ __('Upload By') }}</th>
                                                        <th scope="col">{{ __('Upload Date') }}</th>
                                                        <th scope="col" style="width: 120px;">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($project->attachments as $attachment)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-light text-secondary rounded fs-24">
                                                                            <i class="ri-folder-zip-line"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h5 class="fs-14 mb-0"><a
                                                                                href="javascript:void(0)"
                                                                                class="text-body">{{ $attachment->file_name }}</a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ Storage::has($attachment->file_path) ? $attachment->file_type : '-' }}
                                                            </td>
                                                            <td>{{ Storage::has($attachment->file_path) ? formatFileSize(Storage::size($attachment->file_path)) : '-' }}
                                                            </td>
                                                            <td>{{ $attachment->member ? $attachment->member->name : $attachment->admin->name }}
                                                            </td>
                                                            <td>{{ dateFormate2($attachment->created_at) }}</td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-soft-secondary btn-sm btn-icon"
                                                                        data-bs-toggle="dropdown" aria-expanded="true">
                                                                        <i class="ri-more-fill"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('dashboard.view', $attachment->id) }}"><i
                                                                                    class="ri-eye-fill me-2 align-bottom text-muted"></i>{{ __('View') }}</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('dashboard.attachments.show', $attachment->id) }}"><i
                                                                                    class="ri-download-2-fill me-2 align-bottom text-muted"></i>{{ __('Download') }}</a>
                                                                        </li>
                                                                        @auth('admin')
                                                                            <li class="dropdown-divider"></li>
                                                                            <li>
                                                                                <form id="button-delete-{{ $attachment->id }}"
                                                                                    action="{{ route('dashboard.attachments.destroy', $attachment->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="dropdown-item">
                                                                                        <i class="bx bx-trash me-1"></i>
                                                                                        {{ __('Delete') }}
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                        @endauth
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="project-team" role="tabpanel">
                        <div class="row g-4 mb-3">
                            <div class="col-sm">
                                <div class="d-flex">
                                    <div class="search-box me-2">
                                        <input type="text" class="form-control" placeholder="Search member...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        @php
                            $projectId = $project->id;
                        @endphp

                        <div class="team-list list-view-filter">
                            @foreach ($members as $member)
                                @php
                                    $tasksInProject = $member->tasks->filter(function ($task) use ($projectId) {
                                        return $task->project_id == $projectId;
                                    });
                                @endphp

                                <div class="card team-box">
                                    <div class="card-body px-4">
                                        <div class="row align-items-center team-row">
                                            <div class="col-lg-4 col">
                                                <div class="team-profile-img">
                                                    <div class="avatar-lg img-thumbnail rounded-circle">
                                                        @if ($member->image)
                                                            <img src="{{ Storage::url($member->image) }}" alt="image"
                                                                class="img-fluid d-block rounded-circle">
                                                        @else
                                                            <img src="{{ notUserImage() }}" alt="image"
                                                                class="img-fluid d-block rounded-circle">
                                                        @endif
                                                    </div>
                                                    <div class="team-content">
                                                        @auth('admin')
                                                            <a href="{{ route('dashboard.members.show', $member->id) }}"
                                                                class="d-block">
                                                                <h5 class="fs-16 mb-1">{{ $member->name }}</h5>
                                                            </a>
                                                        @endauth
                                                        @auth('member')
                                                            <span class="d-block">
                                                                <h5 class="fs-16 mb-1">{{ $member->name }}</h5>
                                                            </span>
                                                        @endauth
                                                        <p class="text-muted mb-0">{{ $member->designation->name }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col">
                                                <div class="row text-muted text-center">
                                                    <div class="col-6 border-end border-end-dashed">
                                                        <h5 class="mb-1">{{ $tasksInProject->count() }}</h5>
                                                        <p class="text-muted mb-0">{{ __('Tasks') }}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="mb-1">
                                                            {{ $tasksInProject->where('status', 'completed')->count() }}
                                                        </h5>
                                                        <p class="text-muted mb-0">{{ __('Completed') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @auth('admin')
                                                <div class="col-lg-2 col">
                                                    <div class="text-end">
                                                        <a href="{{ route('dashboard.members.show', $member->id) }}"
                                                            class="btn btn-light view-btn">{{ __('View Profile') }}</a>
                                                    </div>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- end team list -->
                    </div>
                    <!-- end tab pane -->
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
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
