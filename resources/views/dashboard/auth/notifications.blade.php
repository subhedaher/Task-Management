@extends('dashboard.parent')

@section('title', __('Notifications'))

@section('main-title', __('Notifications'))

@section('page', __('Notifications'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Notifications') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>

                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Title: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Title') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Message: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Message') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Message: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Created At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (user()->notifications as $notification)
                                <tr>
                                    <td>{{ $notification->data['title'] }}</td>
                                    <td>{{ $notification->data['message'] }}</td>
                                    <td>{{ dateFormate($notification->created_at) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endSection
