@extends('dashboard.parent')

@section('title', __('Reports'))

@section('main-title', __('Reports'))

@section('page', __('Member'))

@section('content')
    <div class="card-header d-flex align-items-center mb-4">
        <h1 class="card-title mb-0 flex-grow-1 text-danger">{{ __('Member Details') }}</h1>
        <a href="{{ route('dashboard.member.pdf' , $member->id) }}" id="downloadPdfBtn" class="btn btn-primary">
            <i class="ri-file-pdf-line"></i> {{ __('Download PDF') }}
        </a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ $member->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Department:') }}</strong>
                            {{ $member->designation->department->name }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Designation:') }}</strong>
                            {{ $member->designation->name }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Email:') }}</strong>
                            {{ $member->email }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Phone:') }}</strong>
                            {{ $member->phone }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Address:') }}</strong>
                            {{ $member->address }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Admin By:') }}</strong>
                            {{ $member->admin->name }}
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('Created At:') }}</strong>
                            {{ dateFormate2($member->created_at) }}
                        </div>
                    </div>
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
                                    aria-label="Name: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Name') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Task: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Task') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Project: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Project') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Start: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Start') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="End: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('End') }}</th>
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
@endsection
