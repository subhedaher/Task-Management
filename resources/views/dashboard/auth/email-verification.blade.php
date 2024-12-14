@extends('dashboard.auth.parent')

@section('title', __('Email Verification'))

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <div class="text-center mb-5">
                <h5 class="text-primary">{{ __('Welcome Back') }} !</h5>
                <p class="text-muted">{{ __('verify email to continue to system') }}.</p>
            </div>
            <div class="p-2 mt-5">
                <form action="{{ route('sendVerifyEmail') }}" id="formAuthentication" method="POST" class="mb-3">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="mb-3">
                        <input
                            class="btn btn-primary btn-lg d-flex align-items-center justify-content-center d-grid w-100 mt-5"
                            type="submit" value="Request Email Verification" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
