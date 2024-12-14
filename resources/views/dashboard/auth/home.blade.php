@extends('dashboard.auth.parent')

@section('title', __('Home'))

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <div class="mb-5" style="margin-bottom: 50px">
                <h5 class="text-primary">{{ __('Welcome Back') }} !</h5>
                <p class="text-muted">{{ __('Sign in to continue to System.') }}</p>
            </div>

            <div class="d-grid gap-3">
                <!-- Admin Login Button -->
                <a href="{{ route('auth.showlogin', 'admin') }}"
                    class="btn btn-primary btn-lg d-flex align-items-center justify-content-center mt-4">
                    <i class="fas fa-user-shield me-2"></i> {{ __('Login as Admin') }}
                </a>
                <!-- Member Login Button -->
                <a href="{{ route('auth.showlogin', 'member') }}"
                    class="btn btn-success btn-lg d-flex align-items-center justify-content-center">
                    <i class="fas fa-user-tie me-2"></i> {{ __('Login as Member') }}
                </a>
            </div>
        </div>
    </div>
@endsection
