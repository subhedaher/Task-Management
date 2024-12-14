@extends('dashboard.parent')

@section('title', __('Departments'))

@section('main-title', __('Departments'))

@section('page', __('Edit Department'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('Edit Department') }}</h5>
            <form id="form-data" action="{{ route('dashboard.departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name" value="{{ old('name') ?? $department->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Enter Description" cols="30"
                                rows="5">{{ old('description') ?? $department->description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">{{ __('Status: ') }}</label>
                            <input class="form-check-input" @checked($department->status) name="status" @checked(old('status')) type="checkbox"
                                id="formCheck1">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endSection
