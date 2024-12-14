@extends('dashboard.reports.parent')

@section('title', 'Task')

@section('content')
    <h1>{{ __('Task Report') }}</h1>
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $task->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left">
                                <strong>{{ __('Start Date') }}:</strong>
                                <span>{{ formatDateTime($task->start_date) }}</span>
                            </div>
                            <div style="float: right">
                                <strong>{{ __('End Date') }}:</strong>
                                <span>{{ formatDateTime($task->end_date) }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left">
                                <strong>{{ __('Department') }}:</strong>
                                @foreach ($task->project->departments as $department)
                                    <span>{{ $department->name }}</span>
                                @endforeach
                            </div>
                            <div style="float: right">
                                <strong>{{ __('Project Manager') }}:</strong>
                                <span>{{ $task->project->member->name }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left;">
                                <strong>{{ __('Status') }}:</strong>
                                <span>{{ $task->status }}</span>
                            </div>

                            <div style="float: right;">
                                <strong>{{ __('Priority') }}:</strong>
                                <span>{{ $task->priority }}</span>
                            </div>
                        </div>
                        <br>

                        <div class="row" style="margin-bottom: 20px;">
                            <strong>{{ __('Description') }}:</strong>
                            <p style="color: #6c757d;">{{ $task->description }}</p>
                        </div>
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

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('List Activities') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Member') }}</th>
                                    <th>{{ __('Type') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activitiy)
                                    <tr>
                                        <td>{{ $activitiy->member->name }}</td>
                                        <td>{{ $activitiy->type }}</td>
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
                        <h5>{{ __('List Productivities') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Productivity') }}</th>
                                    <th>{{ __('Member') }}</th>
                                    <th>{{ __('Start') }}</th>
                                    <th>{{ __('End') }}</th>
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
