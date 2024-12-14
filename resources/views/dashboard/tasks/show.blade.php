@extends('dashboard.parent')

@section('title', __('Tasks'))

@section('main-title', __('Tasks'))

@section('page', __('Show Task'))

@section('style')
    <style>
        #simplebar-content {
            max-height: 600px;
            overflow-y: auto;
            height: auto;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title mb-3 flex-grow-1 text-start">{{ __('Time Tracking') }}</h6>
                    <div class="mb-2">
                        <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop"
                            colors="primary:#405189,secondary:#02a8b5" style="width:90px;height:90px"></lord-icon>
                    </div>
                    <h3 class="mb-1">{{ \Carbon\Carbon::parse($task->end_date)->diffForHumans() }}</h3>
                    <h5 class="fs-14 mb-4">{{ __('End Date') }}</h5>
                </div>
            </div>
            <!--end card-->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-medium">{{ __('Tasks Title') }}</td>
                                    <td>{{ $task->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">{{ __('Project Name') }}</td>
                                    <td>{{ $task->project->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">{{ __('Project Manager') }}</td>
                                    <td>
                                        @auth('admin')
                                            <a
                                                href="{{ route('dashboard.members.show', $task->project->member->id) }}">{{ $task->project->member->name }}</a>
                                        @endauth
                                        @auth('member')
                                            <p>{{ $task->project->member->name }}</p>
                                        @endauth
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">{{ __('Priority') }}</td>
                                    <td><span
                                            class="badge {{ getPriorityBadgeClass($task->priority) }}">{{ $task->priority }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">{{ __('Status') }}</td>
                                    <td><span
                                            class="badge {{ getStatusBadgeClass($task->status) }}">{{ $task->status }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">{{ __('End Date') }}</td>
                                    <td>{{ dateFormate2($task->end_date) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end table-->
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <h6 class="card-title mb-0 flex-grow-1">{{ __('Assigned To') }}</h6>
                    </div>
                    <ul class="list-unstyled vstack gap-3 mb-0">
                        @foreach ($task->members as $member)
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if ($member->image)
                                            <img src="{{ Storage::url($member->image) }}" alt="image"
                                                class="avatar-xs rounded-circle material-shadow">
                                        @else
                                            <img src="{{ notUserImage() }}" alt="image"
                                                class="avatar-xs rounded-circle material-shadow">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">
                                            @auth('admin')
                                                <a
                                                    href="{{ route('dashboard.members.show', $member->id) }}">{{ $member->name }}</a>
                                            @endauth
                                            @auth('member')
                                                <span>{{ $member->name }}</span>
                                            @endauth
                                        </h6>
                                        <p class="text-muted mb-0">{{ $member->designation->name }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <!--end card-->
        </div>
        <!---end col-->
        <div class="col-xxl-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted">
                        <h6 class="mb-3 fw-semibold text-uppercase">{{ __('Description') }}</h6>
                        <p>{{ $task->description }}</p>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div>
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab"
                                    aria-selected="true">
                                    {{ __('Comments') }} ({{ $task->comments->count() }})
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    {{ __('Attachments File') }} ({{ $task->attachments->count() }})
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    {{ __('Activities') }} ({{ $task->activities->count() }})
                                </a>
                            </li>
                        </ul>
                        <!--end nav-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-1" role="tabpanel">
                            <h5 class="card-title mb-4">{{ __('Comments') }}</h5>
                            <div data-simplebar="init" style="height: 508px;"
                                class="px-3 mx-n3 mb-2 simplebar-scrollable-y">
                                <div class="simplebar-wrapper" style="margin: 0px -16px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                                aria-label="scrollable content"
                                                style="height: 100%; overflow: hidden scroll;">
                                                <div class="simplebar-content" id="simplebar-content"
                                                    style="padding: 0px 16px;">
                                                    @foreach ($task->comments as $comment)
                                                        <div class="d-flex mb-4">
                                                            <div class="flex-shrink-0">
                                                                <i class="ri-message-2-line"></i>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h5 class="fs-13">
                                                                    @auth('admin')
                                                                        <a
                                                                            href="{{ route('dashboard.members.show', $comment->member->id) }}">{{ $comment->member->name === user()->name ? 'You' : $comment->member->name }}
                                                                        </a>
                                                                    @endauth
                                                                    @auth('member')
                                                                        {{ $comment->member->name === user()->name ? 'You' : $comment->member->name }}
                                                                    @endauth
                                                                    <small
                                                                        class="text-muted">{{ dateFormate2($comment->created_at) }}
                                                                        -
                                                                        {{ $comment->created_at->format('h:i a') }}</small>
                                                                </h5>
                                                                <p class="text-muted">{{ $comment->comment }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: 820px; height: 600px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                    <div class="simplebar-scrollbar"
                                        style="height: 430px; transform: translate3d(0px, 0px, 0px); display: block;">
                                    </div>
                                </div>
                            </div>
                            @auth('member')
                                <form id="comment-form" class="mt-4" method="POST"
                                    action="{{ route('dashboard.comments.store') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <label for="exampleFormControlTextarea1"
                                                class="form-label">{{ __('Leave a Comments') }}</label>
                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                            <input type="hidden" name="member_id" value="{{ user()->id }}">
                                            <textarea name="comment" class="form-control bg-light border-light" id="exampleFormControlTextarea1" rows="3"
                                                placeholder="Enter comments"></textarea>
                                            @error('comment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success">{{ __('Post Comments') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @endauth
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="messages-1" role="tabpanel">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">{{ __('File Name') }}</th>
                                            <th scope="col">{{ __('Type') }}</th>
                                            <th scope="col">{{ __('Size') }}</th>
                                            <th scope="col">{{ __('Upload Date') }}</th>
                                            <th scope="col">{{ __('Upload By') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task->attachments as $attachment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm">
                                                            <div
                                                                class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                <i class="ri-file-zip-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a
                                                                    href="javascript:void(0)">{{ $attachment->file_name }}</a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $attachment->file_type }}</td>
                                                <td>{{ Storage::has($attachment->file_path) ? formatFileSize(Storage::size($attachment->file_path)) : '-' }}
                                                </td>
                                                <td>{{ dateFormate2($attachment->created_at) }}</td>
                                                <td>{{ $attachment->member ? $attachment->member->name : $attachment->admin->name }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-soft-secondary btn-sm btn-icon"
                                                            data-bs-toggle="dropdown" aria-expanded="true">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('dashboard.view', $attachment->id) }}"><i
                                                                        class="ri-eye-fill me-2 align-bottom text-muted"></i>{{ __('View') }}</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('dashboard.attachments.show', $attachment->id) }}"><i
                                                                        class="ri-download-2-fill me-2 align-bottom text-muted"></i>{{ __('Download') }}</a>
                                                            </li>
                                                            @auth('admin')
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <form id="button-delete-{{ $attachment->id }}"
                                                                        action="{{ route('dashboard.attachments.destroy', $attachment->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="bx bx-trash me-1"></i>
                                                                            {{ __('Delete') }}
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endauth
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="profile-1" role="tabpanel">
                            <h6 class="card-title mb-4 pb-2">{{ __('Activities') }}</h6>
                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">{{ __('Member') }}</th>
                                            <th scope="col">{{ __('Type') }}</th>
                                            <th scope="col">{{ __('Description') }}</th>
                                            <th scope="col">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task->activities as $activity)
                                            <tr>
                                                <td>{{ $activity->member ? $activity->member->name : $activity->admin->name }}
                                                </td>
                                                <td>{{ $activity->type }}</td>
                                                <td>{{ $activity->description }}</td>
                                                <td>{{ dateFormate2($activity->created_at) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                        <!--edn tab-pane-->

                    </div>
                    <!--end tab-content-->
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('form[id^="button-delete-"]').forEach((form) => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        if ('{{ session('message') }}') {
            Swal.fire({
                title: "Good job!",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }

        $(document).ready(function() {
            $('#comment-form').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        const newComment = response.comment;
                        $('#simplebar-content').append(`
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <i class="ri-message-2-line"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fs-13">
                                @auth('admin')
                                    <a href="http://127.0.0.1:8000/members/${newComment.member_id}">
                                    ${newComment.member_name}
                                </a>
                                @endauth
                                      @auth('member')
                                    ${newComment.member_name}
                                @endauth
                                <small class="text-muted">${newComment.created_at} - ${newComment.time}</small>
                            </h5>
                            <p class="text-muted">${newComment.comment}</p>
                        </div>
                    </div>
                `);

                        $('#exampleFormControlTextarea1').val('');
                        var commentsSection = $('#simplebar-content');
                        commentsSection.scrollTop(commentsSection[0].scrollHeight);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('An error occurred while posting the comment.');
                    }
                });
            });
        });
        $(document).ready(function() {
            var commentsSection = $('#simplebar-content');
            commentsSection.scrollTop(commentsSection[0].scrollHeight);
        });
    </script>
@endsection
