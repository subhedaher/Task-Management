@extends('dashboard.reports.parent')

@section('title', 'Project')

@section('content')
    <h1>{{ __('Project Report') }}</h1>
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $project->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left">
                                <strong>{{ __('Start Date') }}:</strong>
                                <span>{{ dateFormate2($project->start_date) }}</span>
                            </div>
                            <div style="float: right">
                                <strong>{{ __('End Date') }}:</strong>
                                <span>{{ dateFormate2($project->end_date) }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left">
                                <strong>{{ __('Department') }}:</strong>
                                @foreach ($project->departments as $department)
                                <span>{{ $department->name }}</span>
                                @endforeach
                            </div>
                            <div style="float: right">
                                <strong>{{ __('Project Manager') }}:</strong>
                                <span>{{ $project->member->name }}</span>
                            </div>
                        </div>
                        <br>

                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left;">
                                <strong>{{ __('Status') }}:</strong>
                                <span>{{ $project->status }}</span>
                            </div>

                            <div style="float: right;">
                                <strong>{{ __('Priority') }}:</strong>
                                <span>{{ $project->priority }}</span>
                            </div>
                        </div>
                        <br>

                        <div class="row" style="margin-bottom: 20px;">
                            <strong>{{ __('Description') }}:</strong>
                            <p style="color: #6c757d;">{{ $project->description }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('List Tasks') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Task Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Priority') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->status }}
                                        </td>
                                        <td>{{ $task->priority }}
                                        </td>
                                        <td>{{ dateFormate2($task->start_date) }}</td>
                                        <td>{{ dateFormate2($task->end_date) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('List Members') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Member Name') }}</th>
                                    <th>{{ __('Designation') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->designation->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('List Attachments') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('File Name') }}</th>
                                    <th>{{ __('File Type') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attachments as $attachment)
                                    <tr>
                                        <td>{{ $attachment->file_name }}</td>
                                        <td>{{ $attachment->file_type }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
