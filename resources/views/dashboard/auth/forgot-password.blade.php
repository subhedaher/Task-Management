@extends('dashboard.auth.parent')

@section('title', __('Forgot Password'))

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">

            <h5 class="text-primary">{{ __('Forgot Password') }}?</h5>
            <p class="text-muted">{{ __('Reset password with velzon') }}</p>

            <div class="mt-2 text-center">
                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c"
                    class="avatar-xl">
                </lord-icon>
            </div>
            <div class="p-2">
                @session('success')
                    <div class="alert alert-success text-center alert-dismissible" role="alert">
                        <strong> {{ $value }} </strong>
                    </div>
                @endsession
                <form action="{{ route('auth.send') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email"
                            placeholder="Enter Email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-success w-100" type="submit">{{ __('Send Reset Link') }}</button>
                    </div>
                </form><!-- end form -->
            </div>

            <div class="mt-4 text-center">
                <p class="mb-0">{{ __('Wait, I remember my password') }}... <a style="cursor: pointer" onclick="back()"
                        class="fw-semibold text-primary text-decoration-underline"> {{ __('Click here') }} </a> </p>
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
