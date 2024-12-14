@extends('dashboard.parent')

@section('title', __('Members'))

@section('main-title', __('Members'))

@section('page', __('Show Member'))

@section('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="profile-foreground position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg">
                <img src="{{ asset('assets') }}/images/login1.png" alt="image" class="profile-wid-img">
            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
            <div class="row g-4">
                <div class="col-auto">
                    <div class="avatar-lg">
                        @if ($member->image)
                            <img src="{{ storage::url($member->image) }}" alt="image"
                                class="img-thumbnail rounded-circle">
                        @else
                            <img src="{{ notUserImage() }}" alt="image" class="img-thumbnail rounded-circle">
                        @endif
                    </div>
                </div>
                <!--end col-->
                <div class="col">
                    <div class="p-2">
                        <h3 class="text-white mb-1">{{ $member->name }}</h3>
                        <p class="text-white text-opacity-75">{{ $member->roles[0]->name }}</p>
                        <p class="text-white text-opacity-75">{{ $member->designation->name }}</p>
                        <div class="hstack text-white-50 gap-1">
                            <div class="me-2"><i
                                    class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $member->address }}
                            </div>
                            <div>
                                <i
                                    class="ri-list-check me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $member->designation->department->name }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="d-flex profile-wrapper">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab"
                                    aria-selected="true">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">{{ __('Overview') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content pt-4 text-muted">
                        <div class="tab-pane active" id="overview-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-xxl-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">{{ __('Info') }}</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Full Name') }}: </th>
                                                            <td class="text-muted">{{ $member->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Role') }}: </th>
                                                            <td class="text-muted">{{ $member->roles[0]->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Department') }}: </th>
                                                            <td class="text-muted">
                                                                {{ $member->designation->department->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Designation') }}:
                                                            </th>
                                                            <td class="text-muted">{{ $member->designation->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Phone') }}: </th>
                                                            <td class="text-muted">{{ $member->phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Email') }}: </th>
                                                            <td class="text-muted">{{ $member->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Address') }}: </th>
                                                            <td class="text-muted">{{ $member->address }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">{{ __('Joining Date') }}:
                                                            </th>
                                                            <td class="text-muted">{{ dateFormate2($member->created_at) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->

                                </div>
                                <!--end col-->
                                <div class="col-xxl-9">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <h4 class="card-title mb-0  me-2">{{ __('Recent Activity') }}</h4>
                                                    <div class="flex-shrink-0 ms-auto">
                                                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                                            role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" data-bs-toggle="tab"
                                                                    href="#today" role="tab" aria-selected="true">
                                                                    {{ __('Today') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#weekly"
                                                                    role="tab" aria-selected="false" tabindex="-1">
                                                                    {{ __('Weekly') }}
                                                                </a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#monthly"
                                                                    role="tab" aria-selected="false" tabindex="-1">
                                                                    {{ __('Monthly') }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @php
                                                    use Carbon\Carbon;

                                                    $todaysDate = Carbon::today();

                                                    $todayActivities = $member->activities = $member
                                                        ->activities()
                                                        ->whereDate('created_at', $todaysDate)
                                                        ->get();

                                                    $sevenDaysAgo = Carbon::now()->subDays(7);

                                                    $weeklyActivities = $member->activities = $member
                                                        ->activities()
                                                        ->where('created_at', '>=', $sevenDaysAgo)
                                                        ->get();

                                                    $currentMonth = Carbon::now()->month;
                                                    $currentYear = Carbon::now()->year;

                                                    $monthlyActivities = $member->activities = $member
                                                        ->activities()
                                                        ->whereMonth('created_at', $currentMonth)
                                                        ->whereYear('created_at', $currentYear)
                                                        ->get();

                                                @endphp
                                                <div class="card-body">
                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active" id="today" role="tabpanel">
                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush" id="todayExample">
                                                                    @foreach ($todayActivities as $activity)
                                                                        <div class="accordion-item border-0">
                                                                            <div class="accordion-header" id="headingOne">
                                                                                <a class="accordion-button p-2 shadow-none"
                                                                                    data-bs-toggle="collapse"
                                                                                    href="#collapseOne"
                                                                                    aria-expanded="true">
                                                                                    <div class="d-flex">
                                                                                        <div class="flex-shrink-0">
                                                                                            @if ($activity->member->image)
                                                                                                <img src="{{ Storage::url($activity->member->image) }}"
                                                                                                    alt="image"
                                                                                                    class="avatar-xs rounded-circle material-shadow">
                                                                                            @else
                                                                                                <img src="{{ notUserImage() }}"
                                                                                                    alt="image"
                                                                                                    class="avatar-xs rounded-circle material-shadow">
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="flex-grow-1 ms-3">
                                                                                            <!-- Activity Type -->
                                                                                            <p
                                                                                                class="fs-14 text-uppercase text-primary fw-bold mb-1">
                                                                                                {{ $activity->type }}
                                                                                            </p>

                                                                                            <!-- Project and Task Name -->
                                                                                            <h6
                                                                                                class="fs-16 text-dark fw-semibold mb-1">
                                                                                                {{ $activity->task->project->name }}
                                                                                                <span
                                                                                                    class="text-muted">-</span>
                                                                                                {{ $activity->task->name }}
                                                                                            </h6>

                                                                                            <!-- Description and Timestamp -->
                                                                                            <small class="text-muted">
                                                                                                {{ $activity->description }}
                                                                                                <span class="text-primary">
                                                                                                    • </span>
                                                                                                {{ __('on') }}
                                                                                                {{ dateFormate2($activity->created_at) }}
                                                                                                <span
                                                                                                    class="text-secondary">
                                                                                                    | </span>
                                                                                                {{ $activity->created_at->format('h:i a') }}
                                                                                            </small>
                                                                                        </div>

                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <!--end accordion-->
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="weekly" role="tabpanel">
                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush" id="weeklyExample">
                                                                    @foreach ($weeklyActivities as $activity)
                                                                        <div class="accordion-item border-0">
                                                                            <div class="accordion-header" id="headingOne">
                                                                                <a class="accordion-button p-2 shadow-none"
                                                                                    data-bs-toggle="collapse"
                                                                                    href="#collapseOne"
                                                                                    aria-expanded="true">
                                                                                    <div class="d-flex">
                                                                                        <div class="flex-shrink-0">
                                                                                            @if ($activity->member->image)
                                                                                                <img src="{{ Storage::url($activity->member->image) }}"
                                                                                                    alt="image"
                                                                                                    class="avatar-xs rounded-circle material-shadow">
                                                                                            @else
                                                                                                <img src="{{ notUserImage() }}"
                                                                                                    alt="image"
                                                                                                    class="avatar-xs rounded-circle material-shadow">
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="flex-grow-1 ms-3">
                                                                                            <!-- Activity Type -->
                                                                                            <p
                                                                                                class="fs-14 text-uppercase text-primary fw-bold mb-1">
                                                                                                {{ $activity->type }}
                                                                                            </p>

                                                                                            <!-- Project and Task Name -->
                                                                                            <h6
                                                                                                class="fs-16 text-dark fw-semibold mb-1">
                                                                                                {{ $activity->task->project->name }}
                                                                                                <span
                                                                                                    class="text-muted">-</span>
                                                                                                {{ $activity->task->name }}
                                                                                            </h6>

                                                                                            <!-- Description and Timestamp -->
                                                                                            <small class="text-muted">
                                                                                                {{ $activity->description }}
                                                                                                <span class="text-primary">
                                                                                                    • </span>
                                                                                                {{ __('on') }}
                                                                                                {{ dateFormate2($activity->created_at) }}
                                                                                                <span
                                                                                                    class="text-secondary">
                                                                                                    | </span>
                                                                                                {{ $activity->created_at->format('h:i a') }}
                                                                                            </small>
                                                                                        </div>

                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <!--end accordion-->
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="monthly" role="tabpanel">
                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush"
                                                                    id="monthlyExample">
                                                                    @foreach ($monthlyActivities as $activity)
                                                                        <div class="accordion-item border-0">
                                                                            <div class="accordion-header" id="headingOne">
                                                                                <a class="accordion-button p-2 shadow-none"
                                                                                    data-bs-toggle="collapse"
                                                                                    href="#collapseOne"
                                                                                    aria-expanded="true">
                                                                                    <div class="d-flex">
                                                                                        <div class="flex-shrink-0">
                                                                                            @if ($activity->member->image)
                                                                                                <img src="{{ Storage::url($activity->member->image) }}"
                                                                                                    alt="image"
                                                                                                    class="avatar-xs rounded-circle material-shadow">
                                                                                            @else
                                                                                                <img src="{{ notUserImage() }}"
                                                                                                    alt="image"
                                                                                                    class="avatar-xs rounded-circle material-shadow">
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="flex-grow-1 ms-3">
                                                                                            <!-- Activity Type -->
                                                                                            <p
                                                                                                class="fs-14 text-uppercase text-primary fw-bold mb-1">
                                                                                                {{ $activity->type }}
                                                                                            </p>

                                                                                            <!-- Project and Task Name -->
                                                                                            <h6
                                                                                                class="fs-16 text-dark fw-semibold mb-1">
                                                                                                {{ $activity->task->project->name }}
                                                                                                <span
                                                                                                    class="text-muted">-</span>
                                                                                                {{ $activity->task->name }}
                                                                                            </h6>

                                                                                            <!-- Description and Timestamp -->
                                                                                            <small class="text-muted">
                                                                                                {{ $activity->description }}
                                                                                                <span class="text-primary">
                                                                                                    • </span>
                                                                                                {{ __('on') }}
                                                                                                {{ dateFormate2($activity->created_at) }}
                                                                                                <span
                                                                                                    class="text-secondary">
                                                                                                    | </span>
                                                                                                {{ $activity->created_at->format('h:i a') }}
                                                                                            </small>
                                                                                        </div>

                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <!--end accordion-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ __('Projects') }}</h5>
                                            <div class="project-list">
                                                @php
                                                    $taskProjects = $member->tasks
                                                        ->map(function ($task) {
                                                            return $task->project;
                                                        })
                                                        ->unique()
                                                        ->filter();

                                                    $memberProjects = $member->projects
                                                        ->map(function ($project) {
                                                            return $project;
                                                        })
                                                        ->unique()
                                                        ->filter();

                                                    $projects = $taskProjects->merge($memberProjects)->unique();
                                                @endphp


                                                @if ($projects->isNotEmpty())
                                                    @foreach ($projects as $project)
                                                        <div
                                                            class="card profile-project-card shadow-none mb-3 material-shadow">
                                                            <div class="card-body p-4">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                                        <h5 class="fs-14 text-truncate mb-1">
                                                                            <a href="{{ route('dashboard.projects.show', $project->id) }}"
                                                                                class="text-body">{{ $project->name }}</a>
                                                                        </h5>
                                                                        <p class="text-muted text-truncate mb-0">
                                                                            {{ __('Last Update') }}
                                                                            : <span
                                                                                class="fw-semibold text-body">{{ dateFormate($project->updated_at) }}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex-shrink-0 ms-2">
                                                                        <div
                                                                            class="badge {{ getStatusBadgeClass($project->status) }} fs-10">
                                                                            {{ $project->status }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-warning">
                                                        <h5>{{ __('No Projects Available') }}</h5>
                                                        <p>{{ __('This member has not been assigned any projects.') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- end card -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
