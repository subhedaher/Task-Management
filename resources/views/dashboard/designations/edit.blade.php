@extends('dashboard.parent')

@section('title', __('Designations'))

@section('main-title', __('Designations'))

@section('page', __('Edit Designation'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('Edit Designation') }}</h5>
            <form id="form-data" action="{{ route('dashboard.designations.update', $designation->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="department_id" class="form-label">{{ __('Department') }}</label>
                            <select id="department_id" class="form-select" name="department_id">
                                <option></option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == $designation->department->id)
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
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name" value="{{ old('name') ?? $designation->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Enter Description" cols="30"
                                rows="5">{{ old('description') ?? $designation->description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endSection