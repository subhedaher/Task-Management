@extends('dashboard.parent')

@section('title', __('Roles'))

@section('main-title', __('Roles'))

@section('page', __('New Role'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('New Role') }}</h5>
            <form id="data" action="{{ route('dashboard.roles.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="{{ __('Enter Name') }}" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="guard_name" class="form-label">{{ __('Type') }}</label>
                            <select id="guard_name" class="form-select" name="guard_name">
                                <option></option>
                                @foreach ($guards as $k => $guard)
                                    <option value="{{ $k }}" @selected($k == old('guard_name'))>{{ $guard }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guard_name')
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
                title: "{{ __('Good Job') }}",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }
    </script>
@endsection
