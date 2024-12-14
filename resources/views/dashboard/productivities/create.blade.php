@extends('dashboard.parent')

@section('title', __('Productivities'))

@section('main-title', __('Productivities'))

@section('page', __('New Productivity'))

@section('style')
    <!-- Plugins css -->
    <link href="{{ asset('assets') }}/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Layout config Js -->
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <form action="{{ route('dashboard.productivities.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <h5 class="card-header">{{ __('New Productivity') }}</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">{{ __('Title') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Title" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="project_id" class="form-label">{{ __('Project') }}</label>
                                <select class="js-example-basic-single" id="project_id">
                                    <option></option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" @selected($project->id === old('project_id'))>
                                            {{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="task_id" class="form-label">{{ __('Task') }}</label>
                                <select class="js-example-basic-single" name="task_id" id="task_id">
                                    <option></option>
                                </select>
                                @error('task_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">{{ __('Description') }}</label>
                            <textarea class="form-control" placeholder="Enter Description" name="description" id="description" cols="30"
                                rows="10">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="start" class="form-label">{{ __('Start') }}</label>
                                <input type="datetime-local" class="form-control" id="start"
                                    placeholder="Enter due date" data-provider="flatpickr" name="start"
                                    value="{{ old('start') }}">
                                @error('start')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="end" class="form-label">{{ __('End') }}</label>
                                <input type="datetime-local" class="form-control" id="datepicker-deadline-input"
                                    placeholder="Enter due date" data-provider="flatpickr" name="end"
                                    value="{{ old('end') }}">
                                @error('end')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <div class="text-start mb-4">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Add') }}</button>
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
            $('#project_id').change(function() {
                var projecttId = $(this).val();
                if (projecttId) {
                    axios.get(`task/filter/${projecttId}`)
                        .then(function(response) {
                            var tasksSelect = $('#task_id');
                            console.log(tasksSelect);
                            tasksSelect.empty();
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, task) {
                                    tasksSelect.append(
                                        $('<option></option>').val(task.id).text(task
                                            .name)
                                    );
                                });
                            }
                        })
                        .catch(function(error) {
                            console.error('Error fetching tasks:', error);
                        });
                } else {
                    $('#task_id').empty();
                }
            });
        });

        if ('{{ session('message') }}') {
            Swal.fire({
                title: "Good job!",
                text: '{{ session('message') }}',
                icon: "success"
            });
        }
    </script>
@endsection
