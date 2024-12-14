@php
    use Illuminate\Support\Str;
@endphp

<!doctype html>
<html lang="en" dir="ltr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logoo2.png') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('assets') }}/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets') }}/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <link href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets') }}/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets') }}/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @yield('style')
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        @if ($logo ?? null)
                            <div class="navbar-brand-box horizontal-logo">
                                <a href="{{ route('dashboard.home') }}" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="{{ Storage::url($logo) }}" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ Storage::url($logo) }}" alt="" height="17">
                                    </span>
                                </a>
                                <a href="{{ route('dashboard.home') }}" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ Storage::url($logo) }}" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ Storage::url($logo) }}" alt="" height="17">
                                    </span>
                                </a>
                            </div>
                        @endif
                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-1 topbar-head-dropdown header-item">
                            <button type="button"
                                class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="header-lang-img" src="{{ asset('assets') }}/images/flags/us.svg"
                                    alt="Header Language" height="20" class="rounded">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language py-2"
                                    data-lang="en" title="English">
                                    <img src="{{ asset('assets') }}/images/flags/us.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">English</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="sp" title="Spanish">
                                    <img src="{{ asset('assets') }}/images/flags/spain.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">Española</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="gr" title="German">
                                    <img src="{{ asset('assets') }}/images/flags/germany.svg" alt="user-image"
                                        class="me-2 rounded" height="18"> <span
                                        class="align-middle">Deutsche</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="it" title="Italian">
                                    <img src="{{ asset('assets') }}/images/flags/italy.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">Italiana</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="ru" title="Russian">
                                    <img src="{{ asset('assets') }}/images/flags/russia.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">русский</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="ch" title="Chinese">
                                    <img src="{{ asset('assets') }}/images/flags/china.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">中国人</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="fr" title="French">
                                    <img src="{{ asset('assets') }}/images/flags/french.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">français</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language"
                                    data-lang="ar" title="Arabic">
                                    <img src="{{ asset('assets') }}/images/flags/ae.svg" alt="user-image"
                                        class="me-2 rounded" height="18">
                                    <span class="align-middle">Arabic</span>
                                </a>
                            </div>
                        </div>

                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <button type="button"
                                class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-category-alt fs-22'></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                                <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fw-semibold fs-15"> {{ __('System Manager') }} </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="{{ route('dashboard.home') }}">
                                                <i class="fa-solid fa-2x fa-house" style="color: #405189;"></i>
                                                <span>{{ __('Main Panel') }}</span>
                                            </a>
                                        </div>
                                        @auth('admin')
                                            <div class="col">
                                                <a class="dropdown-icon-item"
                                                    href="{{ route('dashboard.admins.index') }}">
                                                    <i class="fa-solid fa-2x fa-user-gear" style="color: #405189;"></i>
                                                    <span>{{ __('Administrators') }}</span>
                                                </a>
                                            </div>
                                        @endauth
                                    </div>
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item"
                                                href="{{ route('dashboard.projects.index') }}">
                                                <i class="fa-solid fa-2x fa-bars-progress" style="color: #405189;"></i>
                                                <span>{{ __('Projects') }}</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item"
                                                href="{{ route('dashboard.tasks.index') }}">
                                                <i class="fa-solid fa-2x fa-list-check" style="color: #405189;"></i>
                                                <span>{{ __('Tasks') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                            <button type="button" id="unreadNotificationsCount"
                                class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                                aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                {{-- @if (count(auth(session('guard'))->user()->unreadNotifications) + $messagesCount > 0) --}}
                                @if (count(auth(session('guard'))->user()->unreadNotifications) > 0)
                                    <span
                                        class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"
                                        {{-- id="countNoti">{{ count(auth(session('guard'))->user()->unreadNotifications) + $messagesCount }} --}}
                                        id="countNoti">{{ count(auth(session('guard'))->user()->unreadNotifications) }}
                                        <span class="visually-hidden">{{ __('Unread Messages') }}</span>
                                    </span>
                                @endif
                            </button>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="notificationDropdown">
                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-white">{{ __('Alerts!') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-2 pt-2">
                                        <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom"
                                            data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                                    role="tab" aria-selected="true">
                                                    {{ __('Notifications') }}
                                                    ({{ count(auth(session('guard'))->user()->unreadNotifications) }})
                                                </a>
                                            </li>
                                            {{-- <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#messages-tab"
                                                    role="tab" aria-selected="false">
                                                    {{ __('Messages')  . ' '}}  ({{ $messagesCount }})
                                                </a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-content position-relative" id="notificationItemsTabContent">
                                    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab"
                                        role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            @foreach (auth(session('guard'))->user()->unreadNotifications->take(4) as $notification)
                                                <a href="{{ route('dashboard.tasks.show', $notification->data['id']) }}"
                                                    class="notification-item-link">
                                                    <div
                                                        class="text-reset notification-item d-block dropdown-item position-relative">
                                                        <div class="d-flex">
                                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                                <span
                                                                    class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                                    <i class="bx bx-badge-check"></i>
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mt-0 mb-2 lh-base">
                                                                    {{ $notification->data['message'] }}</h6>
                                                                <p
                                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                    <span><i class="mdi mdi-clock-outline"></i>
                                                                        {{ $notification->created_at->diffForHumans() }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <div class="my-3 text-center view-all">
                                                <a href="{{ route('auth.notifications') }}"
                                                    class="btn btn-soft-success waves-effect waves-light">
                                                    {{ __('View All Notifications') }} <i
                                                        class="ri-arrow-right-line align-middle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            @foreach ($messagesAll as $message)
                                                <a
                                                    href="{{ route('chat.index', [$message->sender->id, strtolower(class_basename($message->sender))]) }}">
                                                    <div class="text-reset notification-item d-block dropdown-item">
                                                        <div class="d-flex">
                                                            @if ($message->sender->image)
                                                                <img src="{{ Storage::url($message->sender->image) }}"
                                                                    class="me-3 rounded-circle avatar-xs"
                                                                    alt="user-pic">
                                                            @else
                                                                <img src="{{ asset('assets/images/user-dummy.jpg') }}"
                                                                    class="me-3 rounded-circle avatar-xs"
                                                                    alt="user-pic">
                                                            @endif
                                                            <div class="flex-grow-1">
                                                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                                    {{ $message->sender->name }}
                                                                </h6>
                                                                <div class="fs-13 text-muted">
                                                                    <p class="mb-1">{{ $message->message }}</p>
                                                                </div>
                                                                <p
                                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                    <span><i class="mdi mdi-clock-outline"></i>
                                                                        {{ $message->created_at->diffForHumans() }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <!-- Additional messages here -->
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @if (auth(session('guard'))->user()->image)
                                        <img class="rounded-circle header-profile-user"
                                            src="{{ Storage::url(auth(session('guard'))->user()->image) }}"
                                            width="50px" alt="Header Avatar">
                                    @else
                                        <img class="rounded-circle header-profile-user" src="{{ notUserImage() }}"
                                            width="50px" alt="Header Avatar">
                                    @endif
                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth(session('guard'))->user()->name }}</span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ session('guard') }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">{{ __('Welcome') }}
                                    {{ substr(auth(session('guard'))->user()->name, 0, strpos(auth(session('guard'))->user()->name, ' ')) }}
                                    !
                                </h6>
                                <a class="dropdown-item" href="{{ route('auth.editProfile') }}"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">{{ __('Profile') }}</span></a>
                                <a class="dropdown-item" href="{{ route('auth.notifications') }}"><i
                                        class="mdi mdi-alarm-light-outline text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">{{ __('Notifications') }}</span></a>

                                @auth('admin')
                                    <a class="dropdown-item" href="{{ route('dashboard.settings') }}"><i
                                            class="mdi mdi-alert-octagram-outline text-muted fs-16 align-middle me-1"></i>
                                        <span class="align-middle">{{ __('Settings') }}</span></a>
                                @endauth

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('auth.logout', session('guard')) }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">{{ 'Logout' }}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            @if ($logo ?? null)
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{ route('dashboard.home') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ Storage::url($logo) }}" alt="" height="22">
                        </span>
                        <span class="{{ route('dashboard.home') }}">
                            <img src="{{ Storage::url($logo) }}" alt="" height="17">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{ route('dashboard.home') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ Storage::url($logo) }}" alt="" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ Storage::url($logo) }}" alt="" class="pt-2" height="90">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                        id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>
            @endif
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">{{ __('MENU') }}</span></li>
                        @include('dashboard.components.li', [
                            'routeName' => 'dashboard.home',
                            'lable' => __('Home'),
                            'icon' => 'home-line',
                        ])

                        @canany(['Create-Role', 'Read-Roles', 'Update-Roles', 'Delete-Role'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Roles'),
                                'icon' => 'file-user-line',
                                'routeName' => 'roles',
                                'lis' => [
                                    [
                                        'lable' => __('New Role'),
                                        'routeName' => 'dashboard.roles.create',
                                        'permission' => 'Create-Role',
                                    ],
                                    [
                                        'lable' => __('List Roles'),
                                        'routeName' => 'dashboard.roles.index',
                                        'permission' => 'Read-Roles',
                                    ],
                                ],
                            ])
                        @endcanany

                        @canany(['Create-Admin', 'Read-Admins', 'Update-Admin', 'Delete-Admin'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Admins'),
                                'icon' => 'admin-line',
                                'routeName' => 'admins',
                                'lis' => [
                                    [
                                        'lable' => __('New Admin'),
                                        'routeName' => 'dashboard.admins.create',
                                        'permission' => 'Create-Admin',
                                    ],
                                    [
                                        'lable' => __('List Admins'),
                                        'routeName' => 'dashboard.admins.index',
                                        'permission' => 'Read-Admins',
                                    ],
                                ],
                            ])
                        @endcanany



                        @canany(['Create-Department', 'Read-Departments', 'Update-Department', 'Delete-Department'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Departments'),
                                'icon' => 'list-check',
                                'routeName' => 'departments',
                                'lis' => [
                                    [
                                        'lable' => __('New Department'),
                                        'routeName' => 'dashboard.departments.create',
                                        'permission' => 'Create-Department',
                                    ],
                                    [
                                        'lable' => __('List Departments'),
                                        'routeName' => 'dashboard.departments.index',
                                        'permission' => 'Read-Departments',
                                    ],
                                ],
                            ])
                        @endcanany

                        @canany(['Create-Designation', 'Read-Designations', 'Update-Designation', 'Delete-Designation'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Designations'),
                                'icon' => 'code-line',
                                'routeName' => 'designations',
                                'lis' => [
                                    [
                                        'lable' => __('New Designation'),
                                        'routeName' => 'dashboard.designations.create',
                                        'permission' => 'Create-Designation',
                                    ],
                                    [
                                        'lable' => __('List Designations'),
                                        'routeName' => 'dashboard.designations.index',
                                        'permission' => 'Read-Designations',
                                    ],
                                ],
                            ])
                        @endcanany

                        @canany(['Create-Member', 'Read-Members', 'Update-Member', 'Delete-Member'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Members'),
                                'icon' => 'shield-user-line',
                                'routeName' => 'members',
                                'lis' => [
                                    [
                                        'lable' => __('New Member'),
                                        'routeName' => 'dashboard.members.create',
                                        'permission' => 'Create-Member',
                                    ],
                                    [
                                        'lable' => __('List Members'),
                                        'routeName' => 'dashboard.members.index',
                                        'permission' => 'Read-Members',
                                    ],
                                ],
                            ])
                        @endcanany
                        @canany(['Create-Project', 'Read-Projects', 'Update-Project', 'Delete-Project'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Projects'),
                                'icon' => 'article-line',
                                'routeName' => 'projects',
                                'lis' => [
                                    [
                                        'lable' => __('New Project'),
                                        'routeName' => 'dashboard.projects.create',
                                        'permission' => 'Create-Project',
                                    ],
                                    [
                                        'lable' => __('List Projects'),
                                        'routeName' => 'dashboard.projects.index',
                                        'permission' => 'Read-Projects',
                                    ],
                                ],
                            ])
                        @endcanany
                        @canany(['Create-Task', 'Read-Tasks', 'Update-Task', 'Delete-Task'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Tasks'),
                                'icon' => 'task-fill',
                                'routeName' => 'tasks',
                                'lis' => [
                                    [
                                        'lable' => __('New Task'),
                                        'routeName' => 'dashboard.tasks.create',
                                        'permission' => 'Create-Task',
                                    ],
                                    [
                                        'lable' => __('List Tasks'),
                                        'routeName' => 'dashboard.tasks.index',
                                        'permission' => 'Read-Tasks',
                                    ],
                                ],
                            ])
                        @endcanany
                        @canany(['Create-Productivity', 'Read-Productivities', 'Update-Productivity',
                            'Delete-Productivity'])
                            @include('dashboard.components.ul', [
                                'lable' => __('Productivities'),
                                'icon' => 'product-hunt-fill',
                                'routeName' => 'productivities',
                                'lis' => [
                                    [
                                        'lable' => __('New Productivity'),
                                        'routeName' => 'dashboard.productivities.create',
                                        'permission' => 'Create-Productivity',
                                    ],
                                    [
                                        'lable' => __('List Productivities'),
                                        'routeName' => 'dashboard.productivities.index',
                                        'permission' => 'Read-Productivities',
                                    ],
                                ],
                            ])
                        @endcanany
                        @auth('admin')
                            @canany(['Report-Projects', 'Report-Tasks', 'Report-Members'])
                                @include('dashboard.components.ul', [
                                    'lable' => __('Reports'),
                                    'icon' => 'file-list-fill',
                                    'routeName' => 'report',
                                    'lis' => [
                                        [
                                            'lable' => __('Projects'),
                                            'routeName' => 'dashboard.reports.project.index',
                                            'permission' => 'Report-Projects',
                                        ],
                                        [
                                            'lable' => __('Tasks'),
                                            'routeName' => 'dashboard.reports.task.index',
                                            'permission' => 'Report-Tasks',
                                        ],
                                        [
                                            'lable' => __('Members'),
                                            'routeName' => 'dashboard.reports.member.index',
                                            'permission' => 'Report-Members',
                                        ],
                                    ],
                                ])
                            @endcanany
                        @endauth
                        @include('dashboard.components.li', [
                            'routeName' => 'dashboard.calendar',
                            'lable' => __('Calendar'),
                            'icon' => 'calendar-fill',
                        ])
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div
                                class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">@yield('main-title')</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="javascript: void(0);">@yield('page')</a></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- container-fluid -->
                @yield('content')
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © AI Cloud.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Powered By AI Cloud - {{ config('app.name') }}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>

    <!-- Theme Settings -->
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="theme-settings-offcanvas">
        <div class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header">
            <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

            <button type="button" class="btn-close btn-close-white ms-auto" id="customizerclose-btn"
                data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div data-simplebar class="h-100">
                <div class="p-4">
                    <h6 class="mb-0 fw-semibold text-uppercase">Layout</h6>
                    <p class="text-muted">Choose your layout</p>
                    <div class="row gy-3">
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input id="customizer-layout01" name="data-layout" type="radio" value="vertical"
                                    class="form-check-input">
                                <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                    for="customizer-layout01">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Vertical</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal"
                                    class="form-check-input">
                                <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                    for="customizer-layout02">
                                    <span class="d-flex h-100 flex-column gap-1">
                                        <span class="bg-light d-flex p-1 gap-1 align-items-center">
                                            <span class="d-block p-1 bg-primary-subtle rounded me-1"></span>
                                            <span class="d-block p-1 pb-0 px-2 bg-primary-subtle ms-auto"></span>
                                            <span class="d-block p-1 pb-0 px-2 bg-primary-subtle"></span>
                                        </span>
                                        <span class="bg-light d-block p-1"></span>
                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn"
                                    class="form-check-input">
                                <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                    for="customizer-layout03">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 flex-column gap-1">
                                                <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                                <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Two Column</h5>
                        </div>
                        <!-- end col -->

                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input id="customizer-layout04" name="data-layout" type="radio" value="semibox"
                                    class="form-check-input">
                                <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                    for="customizer-layout04">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0 p-1">
                                            <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column pt-1 pe-2">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Semi Box</h5>
                        </div>
                        <!-- end col -->
                    </div>

                    <div class="form-check form-switch form-switch-md mb-3 mt-4">
                        <input type="checkbox" class="form-check-input" id="sidebarUserProfile">
                        <label class="form-check-label" for="sidebarUserProfile">Sidebar User Profile Avatar</label>
                    </div>

                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Theme</h6>
                    <p class="text-muted">Choose your suitable Theme.</p>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme01" name="data-theme" type="radio" value="default"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme01">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/default.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Default</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme02" name="data-theme" type="radio" value="saas"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme02">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo//saas.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Sass</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme03" name="data-theme" type="radio" value="corporate"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme03">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo//corporate.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Corporate</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme04" name="data-theme" type="radio" value="galaxy"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme04">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo//galaxy.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Galaxy</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme05" name="data-theme" type="radio" value="material"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme05">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo//material.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Material</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme06" name="data-theme" type="radio" value="creative"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme06">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/creative.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Creative</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme07" name="data-theme" type="radio" value="minimal"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme07">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/minimal.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Minimal</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme08" name="data-theme" type="radio" value="modern"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme08">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/modern.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Modern</h5>
                        </div>
                        <!-- end col -->
                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme09" name="data-theme" type="radio" value="interactive"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme09">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/interactive.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Interactive</h5>
                        </div><!-- end col -->

                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme10" name="data-theme" type="radio" value="classic"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme10">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/classic.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Classic</h5>
                        </div><!-- end col -->

                        <div class="col-6">
                            <div class="form-check card-radio">
                                <input id="customizer-theme11" name="data-theme" type="radio" value="vintage"
                                    class="form-check-input">
                                <label class="form-check-label p-0" for="customizer-theme11">
                                    <img src="https://themesbrand.com/velzon/{{ asset('assets') }}/images/demo/vintage.png"
                                        alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center fw-medium mt-2">Vintage</h5>
                        </div><!-- end col -->
                    </div>

                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Color Scheme</h6>
                    <p class="text-muted">Choose Light or Dark Scheme.</p>

                    <div class="colorscheme-cardradio">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="data-bs-theme"
                                        id="layout-mode-light" value="light">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="layout-mode-light">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check card-radio dark">
                                    <input class="form-check-input" type="radio" name="data-bs-theme"
                                        id="layout-mode-dark" value="dark">
                                    <label class="form-check-label p-0 avatar-md w-100 bg-dark material-shadow"
                                        for="layout-mode-dark">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                                    <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-visibility">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar Visibility</h6>
                        <p class="text-muted">Choose show or Hidden sidebar.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-visibility"
                                        id="sidebar-visibility-show" value="show">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-visibility-show">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0 p-1">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column pt-1 pe-2">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Show</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-visibility"
                                        id="sidebar-visibility-hidden" value="hidden">
                                    <label class="form-check-label p-0 avatar-md w-100 px-2 material-shadow"
                                        for="sidebar-visibility-hidden">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column pt-1 px-2">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Hidden</h5>
                            </div>
                        </div>
                    </div>

                    <div id="layout-width">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Layout Width</h6>
                        <p class="text-muted">Choose Fluid or Boxed layout.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="data-layout-width"
                                        id="layout-width-fluid" value="fluid">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="layout-width-fluid">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Fluid</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="data-layout-width"
                                        id="layout-width-boxed" value="boxed">
                                    <label class="form-check-label p-0 avatar-md w-100 px-2 material-shadow"
                                        for="layout-width-boxed">
                                        <span class="d-flex gap-1 h-100 border-start border-end">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Boxed</h5>
                            </div>
                        </div>
                    </div>

                    <div id="layout-position">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Layout Position</h6>
                        <p class="text-muted">Choose Fixed or Scrollable Layout Position.</p>

                        <div class="btn-group radio" role="group">
                            <input type="radio" class="btn-check" name="data-layout-position"
                                id="layout-position-fixed" value="fixed">
                            <label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label>

                            <input type="radio" class="btn-check" name="data-layout-position"
                                id="layout-position-scrollable" value="scrollable">
                            <label class="btn btn-light w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Topbar Color</h6>
                    <p class="text-muted">Choose Light or Dark Topbar Color.</p>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar"
                                    id="topbar-color-light" value="light">
                                <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                    for="topbar-color-light">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar"
                                    id="topbar-color-dark" value="dark">
                                <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                    for="topbar-color-dark">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-primary d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                        </div>
                    </div>

                    <div id="sidebar-size">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar Size</h6>
                        <p class="text-muted">Choose a size of Sidebar.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size"
                                        id="sidebar-size-default" value="lg">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-size-default">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size"
                                        id="sidebar-size-compact" value="md">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-size-compact">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Compact</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size"
                                        id="sidebar-size-small" value="sm">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-size-small">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1">
                                                    <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Small (Icon View)</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size"
                                        id="sidebar-size-small-hover" value="sm-hover">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-size-small-hover">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1">
                                                    <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Small Hover View</h5>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-view">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar View</h6>
                        <p class="text-muted">Choose Default or Detached Sidebar view.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-layout-style"
                                        id="sidebar-view-default" value="default">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-view-default">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-layout-style"
                                        id="sidebar-view-detached" value="detached">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-view-detached">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-flex p-1 gap-1 align-items-center px-2">
                                                <span class="d-block p-1 bg-primary-subtle rounded me-1"></span>
                                                <span class="d-block p-1 pb-0 px-2 bg-primary-subtle ms-auto"></span>
                                                <span class="d-block p-1 pb-0 px-2 bg-primary-subtle"></span>
                                            </span>
                                            <span class="d-flex gap-1 h-100 p-1 px-2">
                                                <span class="flex-shrink-0">
                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    </span>
                                                </span>
                                            </span>
                                            <span class="bg-light d-block p-1 mt-auto px-2"></span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Detached</h5>
                            </div>
                        </div>
                    </div>
                    <div id="sidebar-color">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar Color</h6>
                        <p class="text-muted">Choose a color of Sidebar.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio" data-bs-toggle="collapse"
                                    data-bs-target="#collapseBgGradient.show">
                                    <input class="form-check-input" type="radio" name="data-sidebar"
                                        id="sidebar-color-light" value="light">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-color-light">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-white border-end d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio" data-bs-toggle="collapse"
                                    data-bs-target="#collapseBgGradient.show">
                                    <input class="form-check-input" type="radio" name="data-sidebar"
                                        id="sidebar-color-dark" value="dark">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="sidebar-color-dark">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-primary d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient"
                                    aria-expanded="false" aria-controls="collapseBgGradient">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
                                                <span
                                                    class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </button>
                                <h5 class="fs-13 text-center mt-2">Gradient</h5>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="collapse" id="collapseBgGradient">
                            <div class="d-flex gap-2 flex-wrap img-switch p-2 px-3 bg-light rounded">

                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar"
                                        id="sidebar-color-gradient" value="gradient">
                                    <label class="form-check-label p-0 avatar-xs rounded-circle"
                                        for="sidebar-color-gradient">
                                        <span class="avatar-title rounded-circle bg-vertical-gradient"></span>
                                    </label>
                                </div>
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar"
                                        id="sidebar-color-gradient-2" value="gradient-2">
                                    <label class="form-check-label p-0 avatar-xs rounded-circle"
                                        for="sidebar-color-gradient-2">
                                        <span class="avatar-title rounded-circle bg-vertical-gradient-2"></span>
                                    </label>
                                </div>
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar"
                                        id="sidebar-color-gradient-3" value="gradient-3">
                                    <label class="form-check-label p-0 avatar-xs rounded-circle"
                                        for="sidebar-color-gradient-3">
                                        <span class="avatar-title rounded-circle bg-vertical-gradient-3"></span>
                                    </label>
                                </div>
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar"
                                        id="sidebar-color-gradient-4" value="gradient-4">
                                    <label class="form-check-label p-0 avatar-xs rounded-circle"
                                        for="sidebar-color-gradient-4">
                                        <span class="avatar-title rounded-circle bg-vertical-gradient-4"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-img">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Sidebar Images</h6>
                        <p class="text-muted">Choose a image of Sidebar.</p>

                        <div class="d-flex gap-2 flex-wrap img-switch">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidebar-image"
                                    id="sidebarimg-none" value="none">
                                <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-none">
                                    <span
                                        class="avatar-md w-auto bg-light d-flex align-items-center justify-content-center">
                                        <i class="ri-close-fill fs-20"></i>
                                    </span>
                                </label>
                            </div>

                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidebar-image"
                                    id="sidebarimg-01" value="img-1">
                                <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-01">
                                    <img src="{{ asset('assets') }}/images/sidebar/img-1.jpg" alt=""
                                        class="avatar-md w-auto object-fit-cover">
                                </label>
                            </div>

                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidebar-image"
                                    id="sidebarimg-02" value="img-2">
                                <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-02">
                                    <img src="{{ asset('assets') }}/images/sidebar/img-2.jpg" alt=""
                                        class="avatar-md w-auto object-fit-cover">
                                </label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidebar-image"
                                    id="sidebarimg-03" value="img-3">
                                <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-03">
                                    <img src="{{ asset('assets') }}/images/sidebar/img-3.jpg" alt=""
                                        class="avatar-md w-auto object-fit-cover">
                                </label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidebar-image"
                                    id="sidebarimg-04" value="img-4">
                                <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-04">
                                    <img src="{{ asset('assets') }}/images/sidebar/img-4.jpg" alt=""
                                        class="avatar-md w-auto object-fit-cover">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-color">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Primary Color</h6>
                        <p class="text-muted">Choose a color of Primary.</p>

                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-theme-colors"
                                    id="themeColor-01" value="default">
                                <label class="form-check-label avatar-xs p-0" for="themeColor-01"></label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-theme-colors"
                                    id="themeColor-02" value="green">
                                <label class="form-check-label avatar-xs p-0" for="themeColor-02"></label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-theme-colors"
                                    id="themeColor-03" value="purple">
                                <label class="form-check-label avatar-xs p-0" for="themeColor-03"></label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-theme-colors"
                                    id="themeColor-04" value="blue">
                                <label class="form-check-label avatar-xs p-0" for="themeColor-04"></label>
                            </div>
                        </div>
                    </div>

                    <div id="preloader-menu">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Preloader</h6>
                        <p class="text-muted">Choose a preloader.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-preloader"
                                        id="preloader-view-custom" value="enable">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="preloader-view-custom">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                        <!-- <div id="preloader"> -->
                                        <div id="status"
                                            class="d-flex align-items-center justify-content-center">
                                            <div class="spinner-border text-primary avatar-xxs m-auto"
                                                role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Enable</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-preloader"
                                        id="preloader-view-none" value="disable">
                                    <label class="form-check-label p-0 avatar-md w-100 material-shadow"
                                        for="preloader-view-none">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Disable</h5>
                            </div>
                        </div>

                    </div>
                    <!-- end preloader-menu -->

                    <div id="body-img" style="display: none;">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Background Image</h6>
                        <p class="text-muted">Choose a body background image.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-body-image"
                                        id="body-img-none" value="none">
                                    <label class="form-check-label p-0 avatar-md w-100" data-body-image="none"
                                        for="body-img-none">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span
                                                        class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">None</h5>
                            </div>
                            <!-- end col -->
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-body-image"
                                        id="body-img-one" value="img-1">
                                    <label class="form-check-label p-0 avatar-md w-100" data-body-image="img-1"
                                        for="body-img-one">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">One</h5>
                            </div>
                            <!-- end col -->

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-body-image"
                                        id="body-img-two" value="img-2">
                                    <label class="form-check-label p-0 avatar-md w-100" data-body-image="img-2"
                                        for="body-img-two">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Two</h5>
                            </div>
                            <!-- end col -->

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-body-image"
                                        id="body-img-three" value="img-3">
                                    <label class="form-check-label p-0 avatar-md w-100" data-body-image="img-3"
                                        for="body-img-three">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Three</h5>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>

                </div>
            </div>

        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
                </div>
                <div class="col-6">
                    <a href="https://1.envato.market/velzon-admin" target="_blank"
                        class="btn btn-primary w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('assets') }}/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('assets') }}/js/plugins.js"></script>


    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('assets') }}/js/pages/datatables.init.js"></script>
    <!-- App js -->
    <script src="{{ asset('assets') }}/js/app.js"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('assets') }}/js/pages/sweetalerts.init.js"></script>

    <!-- Vector map-->
    <script src="{{ asset('assets') }}/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="{{ asset('assets') }}/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets') }}/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets') }}/js/pages/dashboard-ecommerce.init.js"></script>


    <!-- App js -->
    <script src="{{ asset('build/assets/app-BBhMMEpJ.js') }}"></script>
    <script src="{{ asset('build/assets/app-l0sNRNKZ.js') }}"></script>
    <script src="{{ asset('build/manifest.json') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/js/app.js')
    @yield('scripts')
</body>

</html>
