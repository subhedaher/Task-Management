@extends('dashboard.reports.parent')

@section('title', 'Member')

@section('content')
    <h1>{{ __('Member Report') }}</h1>
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $member->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left">
                                <strong>{{ __('Department') }}:</strong>
                                <span>{{ $member->designation->department->name }}</span>
                            </div>
                            <div style="float: right">
                                <strong>{{ __('Designation') }}:</strong>
                                <span>{{ $member->designation->name }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left;">
                                <strong>{{ __('Email') }}:</strong>
                                <span>{{ $member->email }}</span>
                            </div>

                            <div style="float: right;">
                                <strong>{{ __('Phone') }}:</strong>
                                <span>{{ $member->address }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left;">
                                <strong>{{ __('Address') }}:</strong>
                                <span>{{ $member->address }}</span>
                            </div>

                            <div style="float: right;">
                                <strong>{{ __('Admin By') }}:</strong>
                                <span>{{ $member->admin->name }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float: left;">
                                <strong>{{ __('Created At') }}:</strong>
                                <span>{{ dateFormate2($member->created_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('List Productivities') }}:</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Task') }}</th>
                                    <th>{{ __('Project') }}</th>
                                    <th>{{ __('Start') }}</th>
                                    <th>{{ __('End') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productivities as $productivity)
                                    <tr>
                                        <td>{{ $productivity->name }}</td>
                                        <td>{{ $productivity->task->name }}</td>
                                        <td>{{ $productivity->task->project->name }}</td>
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
    </div>
@endsection
