@extends('dashboard.parent')

@section('title', __('Settings'))

@section('main-title', __('Settings'))

@section('page', __('Settings'))

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">{{ __('Settings') }}</h5>
            <form id="data" action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body" >
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="{{ __('Enter Name') }}" value="{{ old('name') ?? ($setting->name ?? '') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="{{ __('Enter Email') }}" value="{{ old('email') ?? ($setting->email ?? '') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="{{ __('Enter Phone') }}" value="{{ old('phone') ?? ($setting->phone ?? '') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="{{ __('Enter Address') }}" value="{{ old('address') ?? ($setting->address ?? '') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="logo" class="form-label">{{ __('Logo') }}</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                            @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($setting && $setting->logo)
                            <div class="col-md-6 mb-3">
                                <img src="{{ Storage::url($setting->logo) }}" alt="Logo" width="100">
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
