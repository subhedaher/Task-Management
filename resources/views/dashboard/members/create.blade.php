@extends('dashboard.parent')

@section('title', __('Members'))

@section('main-title', __('Members'))

@section('page', __('New Member'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('New Member') }}</h5>
            <form id="form-data" action="{{ route('dashboard.members.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="department_id" class="form-label">{{ __('Department') }}</label>
                            <select id="department_id" class="form-select" name="department_id">
                                <option></option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == old('department_id'))>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="designation_id" class="form-label">{{ __('Designation') }}</label>
                            <select id="designation_id" class="form-select" name="designation_id">
                                <option></option>
                            </select>
                            @error('designation_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter Email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                placeholder="Enter Phone Number" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Enter Address" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Password" value="{{ old('password') }}">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Password Confirmation') }}</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="Enter Password Confirmation"
                                value="{{ old('password_confirmation') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">{{ __('Role') }}</label>
                            <select id="role_id" class="form-select" name="role_id">
                                <option></option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @selected($role->id == old('role_id'))>{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                </div>
            </form>
        </div>
    </div>
@endSection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#department_id').change(function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    axios.get(`designation/filter/${departmentId}`)
                        .then(function(response) {
                            var designationSelect = $('#designation_id');
                            designationSelect.empty();
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, designation) {
                                    designationSelect.append(
                                        $('<option></option>').val(designation.id).text(
                                            designation.name)
                                    );
                                });
                            }
                        })
                        .catch(function(error) {
                            console.error('Error fetching designations:', error);
                        });
                } else {
                    $('#designation_id').empty();
                }
            });
        });


        if ('{{ session('message') }}') {
            Swal.fire({
                title: "Good job!",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }
    </script>
@endsection
