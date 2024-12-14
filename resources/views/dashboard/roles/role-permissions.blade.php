@extends('dashboard.parent')

@section('title', __('Roles'))

@section('main-title', __('Roles'))

@section('page', __('Show Role'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('Permissions') }} | <span
                            style="font-weight: bold;color:red">{{ $role->name }}</h5>
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
                                    aria-label="Permission: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Permission') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="User Type: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('User Type') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input class="form-check-input" type="checkbox"
                                                onchange="updateRolePermission('{{ $permission->id }}')"
                                                @checked($permission->assigned)>
                                            <label for="permission-{{ $permission->id }}">
                                            </label>
                                        </div>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endSection


@section('scripts')
    <script>
        function updateRolePermission(id) {
            axios.put('{{ route('dashboard.roles.updateRolePermission') }}', {
                    role_id: '{{ $role->id }}',
                    permission_id: id
                })
                .then(function(response) {
                    Swal.fire({
                        title: "Good job!",
                        text: response.data.message,
                        icon: "success"
                    });
                })
                .catch(function(error) {
                    Swal.fire({
                        title: "Oops...",
                        text: response.data.message,
                        icon: "error"
                    });
                });
        }
    </script>

@endsection
