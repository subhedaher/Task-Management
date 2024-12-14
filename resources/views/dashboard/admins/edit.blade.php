@extends('dashboard.parent')

@section('title', __('Admins'))

@section('main-title', __('Admins'))

@section('page', __('Edit Admin'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('Edit Admin') }}</h5>
            <form id="form-data" action="{{ route('dashboard.admins.update', $admin->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                name="name" value="{{ old('name') ?? $admin->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                name="email" value="{{ old('email') ?? $admin->email }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter Phone Number"
                                value="{{ old('phone') ?? $admin->phone }}" name="phone">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter Address" value="{{ old('address') ?? $admin->address }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">{{ __('Role') }}</label>
                            <select id="role_id" class="form-select" name="role_id">
                                <option></option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @selected($role->id == old('role_id'))
                                        @selected($admin->roles[0]->id == $role->id)>
                                        {{ $role->name }}
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
                            <input class="form-check-input" @checked($admin->status) name="status" @checked(old('status')) type="checkbox"
                                id="formCheck1">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endSection
