@extends('dashboard.parent')

@section('title', __('Roles'))

@section('main-title', __('Roles'))

@section('page', __('List Roles'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Roles') }}</h5>
                    <div>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#createrRoleModal">{{ __('Add New Role') }}</button>
                    </div>
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
                                    aria-label="role: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Role') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Type: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Type') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Count Permission: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('Count Permissions') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending"
                                    style="width: 42.4px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ $role->permissions_count }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li><a href="{{ route('dashboard.roles.show', $role->id) }}"
                                                        class="dropdown-item edit-item-btn"><i
                                                            class="ri-eye-line align-bottom me-2 text-muted"></i>
                                                        {{ __('permissions') }}</a></li>
                                                @if ($role->name !== 'Super Admin' && $role->name !== 'Project Manager' && $role->name !== 'Member')
                                                    <li><a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                                            class="dropdown-item show-item-btn"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            {{ __('edit') }}</a></li>
                                                    <li>
                                                        <form id="button-delete-{{ $role->id }}"
                                                            action="{{ route('dashboard.roles.destroy', $role->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bx bx-trash me-1"></i> {{ __('delete') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="createrRoleModal" tabindex="-1" aria-labelledby="createrSuperviserModalLable"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="creatertaskModalLabel">{{ __('New Role') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="data" action="{{ route('dashboard.roles.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xxl-6">
                                        <label for="name" class="form-label">{{ __('Name') }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Enter Name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <label for="guard_name" class="form-label">{{ __('Type') }}</label>
                                        <select id="guard_name"
                                            class="form-select @error('guard_name') is-invalid @enderror"
                                            name="guard_name">
                                            @foreach ($guards as $k => $guard)
                                                <option value="{{ $k }}">
                                                    {{ $guard }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('guard_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
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
                    title: '{{ __('Are You Sure') }}',
                    text: "{{ __('You Wont Be Able To Revert') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('Yes Delete It') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if (session('message'))
            Swal.fire({
                title: '{{ __('Good Job') }}',
                text: '{{ session('message') }}',
                icon: 'success'
            });
        @endif
    </script>
@endsection
