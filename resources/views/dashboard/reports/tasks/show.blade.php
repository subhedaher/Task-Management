@extends('dashboard.parent')

@section('title', __('Reports'))

@section('main-title', __('Reports'))

@section('page', __('Task'))

@section('content')
    <div class="card-header d-flex align-items-center mb-4">
        <h1 class="card-title mb-0 flex-grow-1 text-danger">{{ __('Task Details') }}</h1>
        <a href="{{ route('dashboard.task.pdf', $task->id) }}" id="downloadPdfBtn" class="btn btn-primary">
            <i class="ri-file-pdf-line"></i> {{ __('Download PDF') }}
        </a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ $task->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Start Date') }}:</strong>
                            {{ dateFormate2($task->start_date) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('End Date') }}:</strong>
                            {{ dateFormate2($task->end_date) }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Department') }}:</strong>
                            {{ $task->project->name }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Department') }}:</strong>
                            @foreach ($task->project->departments as $department)
                                {{ $department->name . ' ' }}
                            @endforeach
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Status') }}:</strong>
                            <span class="badge {{ getStatusBadgeClass($task->status) }}">{{ $task->status }}</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Priority') }}:</strong>
                            <span class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ $task->priority }}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>{{ __('Description') }}:</strong>
                            <p class="text-muted">{{ $task->description }}</p>
                        </div>
                    </div>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Activities') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Activitie: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Activitie') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Type: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('type') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Description: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Description') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Created At: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Created At') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activitie)
                                <tr>
                                    <td>{{ $activitie->member->name }}</td>
                                    <td>{{ $activitie->type }}</td>
                                    <td>{{ $activitie->description }}</td>
                                    <td>{{ dateFormate($activitie->created_at) }}</td>
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
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Productivities') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Activitie: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Productivity') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Type: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Member') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Description: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Start') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="End: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('End') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productivities as $productivity)
                                <tr>
                                    <td>{{ $productivity->name }}</td>
                                    <td>{{ $productivity->member->name }}</td>
                                    <td>{{ formatDateTime($productivity->start) }}
                                    </td>
                                    <td>{{ formatDateTime($productivity->end) }}</td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
