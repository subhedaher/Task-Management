@extends('dashboard.parent')

@section('title', __('Projects'))

@section('main-title', __('Projects'))

@section('page', __('Edit Project'))

@section('style')
    <!-- Plugins css -->
    <link href="{{ asset('assets') }}/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Layout config Js -->
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <form action="{{ route('dashboard.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <h5 class="card-header">{{ __('Edit Project') }}</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">{{ __('Title') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Title" value="{{ old('name') ?? $project->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">{{ __('Description') }}</label>
                            <textarea class="form-control" placeholder="Enter Description" name="description" id="description" cols="30"
                                rows="10">{{ old('description') ?? $project->description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <label for="department_id" class="form-label">{{ __('Departments') }}</label>
                                <select class="js-example-basic-multiple" id="department_id" name="departments[]"
                                    multiple="multiple">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @selected($project->departments->contains('id', $department->id))>
                                            {{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('departments')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="member_id" class="form-label">{{ __('Project Manager') }}</label>
                                <select class="form-select member_id" data-choices data-choices-search-false
                                    id="choices-status-input" name="member_id">
                                    <option></option>
                                    <option value="{{ $project->member->id }}" @selected(true)>
                                        {{ $project->member->name }}</option>
                                </select>
                                @error('member_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="priority" class="form-label">{{ __('Priority') }}</label>
                                <select class="form-select" data-choices data-choices-search-false
                                    id="choices-priority-input" name="priority">
                                    <option></option>
                                    @foreach ($priorities as $k => $priority)
                                        <option value="{{ $k }}" @selected($k === $project->priority)
                                            @selected($k === old('priority'))>
                                            {{ $priority }}</option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select class="form-select" data-choices data-choices-search-false
                                    id="choices-priority-input" name="status">
                                    <option></option>
                                    @foreach ($statuses as $k => $status)
                                        <option value="{{ $k }}" @selected($k === $project->status)
                                            @selected($k === old('status'))>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" class="form-control" id="start_date" placeholder="Enter due date"
                                    data-provider="flatpickr" name="start_date"
                                    value="{{ old('start_date') ?? $project->start_date }}">
                                @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                <input type="date" class="form-control" id="datepicker-deadline-input"
                                    placeholder="Enter due date" data-provider="flatpickr" name="end_date"
                                    value="{{ old('end_date') ?? $project->end_date }}">
                                @error('end_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="attachments" class="form-label">{{ __('Attachments') }}</label>
                                <input class="form-control" type="file" name="attachments[]" id="attachments" multiple>
                                @error('attachments.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if ($project->attachments->count() > 0)
                                <div class="col-lg-12 mb-3">
                                    <label for="existingAttachments"
                                        class="form-label">{{ __('Existing Attachments') }}</label>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($project->attachments as $attachment)
                                            <div class="me-3 mb-3">
                                                @php
                                                    // Get the file extension
                                                    $extension = pathinfo($attachment->file_path, PATHINFO_EXTENSION);
                                                @endphp

                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                    {{-- Display image files --}}
                                                    <img src="{{ Storage::url($attachment->file_path) }}"
                                                        alt="attachment" class="img-thumbnail"
                                                        style="width: 100px; height: 100px;">
                                                @elseif($extension == 'pdf')
                                                    {{-- Display PDF files --}}
                                                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">
                                                        <img src="{{ asset('assets/images/pdf-icon.png') }}"
                                                            alt="PDF attachment" class="img-thumbnail"
                                                            style="width: 100px; height: 100px;">
                                                    </a>
                                                @else
                                                    {{-- Display link for other file types (e.g., doc, docx, etc.) --}}
                                                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                                        class="btn btn-primary">
                                                        {{ __('Download') }} {{ $extension }}
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <!-- end card -->
                <div class="text-start mb-4">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <!-- ckeditor -->
    <script src="{{ asset('assets') }}/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <!-- dropzone js -->
    <script src="{{ asset('assets') }}/libs/dropzone/dropzone-min.js"></script>
    <!-- project-create init -->
    <script src="{{ asset('assets') }}/js/pages/project-create.init.js"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets') }}/js/pages/select2.init.js"></script>

    <script>
        $(document).ready(function() {
            $('#department_id').change(function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    axios.get(`members/filter/${departmentId}`)
                        .then(function(response) {
                            var membersSelect = $('.member_id');
                            membersSelect.empty();
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, member) {
                                    membersSelect.append(
                                        $('<option></option>').val(member.id).text(member
                                            .name)
                                    );
                                });
                            }
                        })
                        .catch(function(error) {
                            console.error('Error fetching members:', error);
                        });
                } else {
                    $('#member_id').empty();
                }
            });
        });
    </script>
@endsection
