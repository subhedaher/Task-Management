@extends('dashboard.parent')

@section('title', __('Departments'))

@section('main-title', __('Departments'))

@section('page', __('New Department'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('New Department') }}</h5>
            <form id="form-data" action="{{ route('dashboard.departments.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Enter Description" cols="30"
                                rows="5">{{ old('description') }}</textarea>
                            @error('description')
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
        if ('{{ session('message') }}') {
            Swal.fire({
                title: "Good job!",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }
    </script>
@endsection
