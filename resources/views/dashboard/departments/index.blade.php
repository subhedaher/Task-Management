@extends('dashboard.parent')

@section('title', __('Departments'))

@section('main-title', __('Departments'))

@section('page', __('List Departments'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Departments') }}</h5>
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
                                    aria-label="Department: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Department') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Description: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Description') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Designations: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Designations') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Active: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Status') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Created At: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Created At') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Active: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Action') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ Str::limit($department->description, 50) }}</td>
                                    <td>{{ $department->designations_count }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $department->status ? 'success' : 'danger' }}-subtle text-{{ $department->status ? 'success' : 'danger' }}">{{ $department->statusActive }}</span>
                                    </td>
                                    <td>{{ dateFormate($department->created_at) }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <button class="dropdown-item" data-bs-target="#showDepartmentModal"
                                                    data-bs-toggle="modal" data-id="{{ $department->id }}"
                                                    onclick="showDepartmentInfo(this)">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    {{ __('Show') }}
                                                </button>
                                                <li><a href="{{ route('dashboard.departments.edit', $department->id) }}"
                                                        class="dropdown-item edit-item-btn"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        {{ __('Edit') }}</a></li>
                                                <li>
                                                    <form id="button-delete-{{ $department->id }}"
                                                        action="{{ route('dashboard.departments.destroy', $department->id) }}"
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
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="showDepartmentModal" tabindex="-1" aria-labelledby="showDepartmentModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="showDepartmentModalLabel">Department Details</h5>
                    <button type="button" class="btn-close" id="showDepartmentBtn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Department Name') }}:</strong>
                            <p id="departmentNameDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Description') }}:</strong>
                            <p id="departmentDescriptionDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Count of Designations') }}:</strong>
                            <p id="designationCountDisplay"></p>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <strong>{{ __('Active Status') }}:</strong>
                            <p id="activeStatusDisplay"></p>
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

        if ('{{ session('error') }}') {
            Swal.fire({
                title: "Oops...",
                text: '{{ session('error') }}',
                icon: "error"
            });
        }

        function showDepartmentInfo(button) {
            const departmentId = button.getAttribute('data-id');

            fetch(`/departments/${departmentId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('departmentNameDisplay').innerText = data.name;
                    document.getElementById('departmentDescriptionDisplay').innerText = data.description;
                    document.getElementById('designationCountDisplay').innerText = data.designations_count;
                    const activeBadge = data.active === 'Active' ?
                        `<span class="badge bg-success-subtle text-success">${data.active}</span>` :
                        `<span class="badge bg-danger-subtle text-danger">${data.active}</span>`;
                    document.getElementById('activeStatusDisplay').innerHTML = activeBadge;
                })
                .catch(error => console.error('Error fetching department data:', error));
        }
    </script>
@endsection
