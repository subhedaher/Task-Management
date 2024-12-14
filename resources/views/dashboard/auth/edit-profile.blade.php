@extends('dashboard.parent')

@section('title', __('Edit Profile'))

@section('main-title', __('Edit Profile'))

@section('page', __('Edit Profile'))

@section('content')
    <div class="container-fluid">
        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{ asset('assets') }}/images/login1.png" class="profile-wid-img" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                @error('imageUser')
                                    <div class="alert alert-danger mb-xl-0 material-shadow mb-3" role="alert">
                                        <strong> {{ $errors->first() }} </strong>
                                    </div>
                                @enderror
                                @if (auth(session('guard'))->user()->image)
                                    <img src="{{ Storage::url(auth(session('guard'))->user()->image) }}"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                        alt="user-profile-image">
                                @else
                                    <img src="{{ notUserImage() }}"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                        alt="user-profile-image">
                                @endif
                                <form action="{{ route('saveImage') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="imageUser" name="imageUser" type="file"
                                            class="profile-img-file-input">
                                        <label for="imageUser" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div><br>
                                    <input type="submit" value="Save" class="btn btn-primary d-block">
                                </form>
                            </div>
                            <h5 class="fs-16 mb-1">{{ auth(session('guard'))->user()->name }}</h5>
                            <p class="text-muted mb-0">{{ session('guard') }}</p>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab"
                                    aria-selected="true">
                                    <i class="fas fa-home"></i> {{ __('Personal Details') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="far fa-user"></i> {{ __('Change Password') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('auth.updateProfile') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Enter Name"
                                                    value="{{ old('name') ?? auth(session('guard'))->user()->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Enter Email" name="email"
                                                    value="{{ old('email') ?? auth(session('guard'))->user()->email }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                                <input type="text" class="form-control" id="phone"
                                                    placeholder="Enter phone number" name="phone"
                                                    value="{{ old('phone') ?? auth(session('guard'))->user()->phone }}">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                                <input type="text" class="form-control" id="address"
                                                    placeholder="Enter Address" name="address"
                                                    value="{{ old('address') ?? auth(session('guard'))->user()->address }}">
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ __('Updates') }}</button>
                                                <a href="{{ route('dashboard.home') }}" type="button"
                                                    class="btn btn-soft-success">{{ __('Cancel') }}</a>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="{{ route('auth.updatePassword') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-2">
                                        <div class="col-lg-4 mb-3">
                                            <div>
                                                <label for="oldpassword"
                                                    class="form-label">{{ __('Old Password*') }}</label>
                                                <input type="password" class="form-control" id="oldpassword"
                                                    placeholder="Enter current password" name="oldpassword">
                                                @error('oldpassword')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4 mb-3">
                                            <div>
                                                <label for="newpassword"
                                                    class="form-label">{{ __('New Password*') }}</label>
                                                <input type="password" class="form-control" id="newpassword"
                                                    placeholder="Enter new password" name="newpassword">
                                                @error('newpassword')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4 mb-3">
                                            <div>
                                                <label for="newpasword_confirmation"
                                                    class="form-label">{{ __('Confirm
                                                                                                                                                                                                                Password*') }}</label>
                                                <input type="password" class="form-control" id="newpasword_confirmation"
                                                    placeholder="Confirm password" name="newpassword_confirmation">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit"
                                                    class="btn btn-success">{{ __('Change Password') }}</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
@endsection

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
