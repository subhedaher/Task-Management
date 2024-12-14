@extends('dashboard.parent')

@section('title', __('Productivities'))

@section('main-title', __('Productivities'))

@section('page', __('List Productivities'))

@section('content')
    <div class="row">
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
                                    aria-label="#: activate to sort column descending" style="width: 10.4px;">
                                    #</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Productivity: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Productivity') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Task: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Task') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Member: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Member') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Description: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Description') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Start: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Start') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="End: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('End') }}</th>
                                    <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productivities as $productivity)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $productivity->name }}</td>
                                    <td>{{ $productivity->task->name }}</td>
                                    <td>{{ $productivity->member->name }}</td>
                                    <td>{{ Str::limit($productivity->description, 20) }}</td>
                                    <td>{{ formatDateTime($productivity->start) }}
                                    </td>
                                    <td>{{ formatDateTime($productivity->end) }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <button class="dropdown-item" data-bs-target="#showProductivityModal"
                                                    data-bs-toggle="modal" data-id="{{ $productivity->id }}"
                                                    onclick="showProductivityModal(this)">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    {{ __('Show') }}
                                                </button>
                                            </ul>
                                        </div>
                                    </td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showProductivityModal" tabindex="-1" aria-labelledby="showProductivityLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="showProductivityLabel">Department Details</h5>
                    <button type="button" class="btn-close" id="showDepartmentBtn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Productivity Name') }}:</strong>
                            <p id="productivityNameDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Task Name') }}:</strong>
                            <p id="taskNameDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Project Name') }}:</strong>
                            <p id="projectNameDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Member Name') }}:</strong>
                            <p id="memberNameDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Description') }}:</strong>
                            <p id="productivityDescriptionDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Start') }}:</strong>
                            <p id="startDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('End') }}:</strong>
                            <p id="endDisplay"></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        function showProductivityModal(button) {
            const productivityId = button.getAttribute('data-id');

            fetch(`/productivities/${productivityId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('productivityNameDisplay').innerText = data.name;
                    document.getElementById('taskNameDisplay').innerText = data.task_name;
                    document.getElementById('projectNameDisplay').innerText = data.project_name;
                    document.getElementById('memberNameDisplay').innerText = data.member_name;
                    document.getElementById('productivityDescriptionDisplay').innerText = data.description;
                    document.getElementById('startDisplay').innerText = data.start;
                    document.getElementById('endDisplay').innerText = data.end;
                  
                })
                .catch(error => console.error('Error fetching department data:', error));
        }
    </script>
@endsection
