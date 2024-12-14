@extends('dashboard.auth.parent')

@section('title', __('Recover Password'))

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <div class="text-center mb-5">
                <h5 class="text-primary">{{ __('Create new password') }}</h5>
                <p class="text-muted">
                    {{ __('Your new password must be different from previous used password.') }}
                </p>
            </div>
            <div class="p-2">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="password-input">{{ __('Password') }}</label>
                        <div class="position-relative auth-pass-inputgroup">
                            <input type="password" name="password" class="form-control pe-5 password-input"
                                placeholder="Enter password" id="password-input">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button
                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm-password-input">{{ __('Confirm Password') }}</label>
                        <div class="position-relative auth-pass-inputgroup mb-3">
                            <input type="password" name="password_confirmation" class="form-control pe-5 password-input"
                                placeholder="Confirm password">
                            <button
                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                type="button"><i class="ri-eye-fill align-middle"></i></button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-success w-100" type="submit">{{ __('Reset Password') }}</button>
                    </div>

                </form>
            </div>

            <div class="mt-5 text-center">
                <p class="mb-0">{{ __('Wait, I remember my password') }}... <a
                        href="{{ route('auth.showlogin', session('guard')) }}"
                        class="fw-semibold text-primary text-decoration-underline"> {{ __('Click here') }} </a> </p>
            </div>
        </div>
    </div>
@endsection
