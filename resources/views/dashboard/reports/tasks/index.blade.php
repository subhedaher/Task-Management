@extends('dashboard.parent')

@section('title', __('Reports'))

@section('main-title', __('Reports'))

@section('page', __('Tasks'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('Task Reports') }}</h5>
                    <a href="#" id="downloadPdfBtn" class="btn btn-primary">
                        <i class="ri-file-pdf-line"></i> {{ __('Download PDF') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="filterStatus">{{ __('Filter by Status') }}</label>
                            <select id="filterStatus" class="form-select">
                                <option value="all">{{ __('All') }}</option>
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="processing">{{ __('Processing') }}</option>
                                <option value="completed">{{ __('Completed') }}</option>
                                <option value="cancled">{{ __('Cancled') }}</option>
                                <option value="overdue">{{ __('Overdue') }}</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="filterPriority">{{ __('Filter by Priority') }}</label>
                            <select id="filterPriority" class="form-select">
                                <option value="all">{{ __('All') }}</option>
                                <option value="low">{{ __('Low') }}</option>
                                <option value="medium">{{ __('Medium') }}</option>
                                <option value="high">{{ __('High') }}</option>
                            </select>
                        </div>
                    </div>

                    <table id="tasksTable" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('Task Name') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Priority') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr data-status="{{ $task->status }}" data-priority="{{ $task->priority }}">
                                    <td>{{ $task->name }}</td>
                                    <td>{{ dateFormate2($task->start_date) }}</td>
                                    <td>{{ dateFormate2($task->end_date) }}</td>
                                    <td>
                                        <span class="badge {{ getStatusBadgeClass($task->status) }}">
                                            {{ $task->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ getPriorityBadgeClass($task->priority) }}">
                                            {{ $task->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.reports.task.task', $task->id) }}"
                                            class="btn btn-primary">
                                            {{ __('View Details') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function filterTasks() {
            var filterStatus = document.getElementById('filterStatus').value;
            var filterPriority = document.getElementById('filterPriority').value;

            var tasks = document.querySelectorAll('#tasksTable tbody tr');

            tasks.forEach(function(task) {
                var status = task.getAttribute('data-status');
                var priority = task.getAttribute('data-priority');

                var showTask = (filterStatus === 'all' || filterStatus === status) &&
                    (filterPriority === 'all' || filterPriority === priority);

                if (showTask) {
                    task.style.display = '';
                } else {
                    task.style.display = 'none';
                }
            });
        }

        document.getElementById('filterStatus').addEventListener('change', filterTasks);
        document.getElementById('filterPriority').addEventListener('change', filterTasks);

        document.getElementById('downloadPdfBtn').addEventListener('click', function(e) {
            e.preventDefault();

            var status = document.getElementById('filterStatus').value;
            var priority = document.getElementById('filterPriority').value;

            var url = "{{ route('dashboard.tasks.pdf') }}" + "?status=" + status + "&priority=" + priority;

            window.location.href = url;
        });
    </script>
@endsection
