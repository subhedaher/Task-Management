@extends('dashboard.parent')

@section('title', __('Members'))

@section('main-title', __('Members'))

@section('page', __('Edit Member'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('Edit Member') }}</h5>
            <form id="form-data" action="{{ route('dashboard.members.update', $member->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="department_id" class="form-label">{{ __('Department') }}</label>
                            <select id="department_id" class="form-select" name="department_id">
                                <option></option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == $member->designation->department->id)
                                        @selected($department->id == old('department_id'))>
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
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}" @selected($designation->id == $member->designation_id)
                                        @selected($designation->id == old('designation_id'))>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('designation_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name" value="{{ old('name') ?? $member->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter Email" value="{{ old('email') ?? $member->email }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                placeholder="Enter Phone Number" value="{{ old('phone') ?? $member->phone }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Enter Address" value="{{ old('address') ?? $member->address }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">{{ __('Role') }}</label>
                            <select id="role_id" class="form-select" name="role_id">
                                <option></option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @selected($role->id == $member->roles[0]->id)
                                        @selected($role->id == old('role_id'))>{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">{{ __('Status: ') }}</label>
                            <input class="form-check-input" @checked($member->status) name="status"
                                @checked(old('status')) type="checkbox" id="formCheck1">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
    </script>
@endsection
