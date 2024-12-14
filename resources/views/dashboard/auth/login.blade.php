@extends('dashboard.auth.parent')

@section('title', __('Sign in'))

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <div>
                <h5 class="text-primary">{{ __('Welcome Back') }} !</h5>
                <p class="text-muted">{{ __('Sign in to continue to System.') }}</p>
            </div>

            <div class="p-2 mt-4">
                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    @session('message')
                        <div class="alert alert-danger mb-xl-2 material-shadow" role="alert">
                            <strong> {{ $value }} </strong>
                        </div>
                    @endsession
                    @session('success')
                        <div class="alert alert-success mb-xl-2 material-shadow" role="alert">
                            <strong> {{ $value }} </strong>
                        </div>
                    @endsession
                    @session('error')
                        <div class="alert alert-success mb-xl-2 material-shadow" role="alert">
                            <strong> {{ $value }} </strong>
                        </div>
                    @endsession
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="float-end">
                            <a href="{{ route('auth.forget') }}" class="text-muted">{{ __('Forgot password?') }}</a>
                        </div>
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        <div class="position-relative auth-pass-inputgroup mb-3">
                            <input type="password" class="form-control pe-5 password-input" placeholder="Enter Password"
                                id="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button
                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                        <label class="form-check-label" for="auth-remember-check">{{ __('Remember me') }}</label>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-success w-100" type="submit">{{ __('Sign In') }}</button>
                        <div class="float-start mt-2">
                            <a style="cursor: pointer" onclick="back()" class="text-muted">{{ __('back?') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function back() {
            window.history.back();
        }
    </script>
@endsection
