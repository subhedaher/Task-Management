@extends('dashboard.parent')

@section('title', __('Reports'))

@section('main-title', __('Reports'))

@section('page', __('Members'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ __('Member Reports') }}</h5>
                    <a href="#" id="downloadPdfBtn" class="btn btn-primary">
                        <i class="ri-file-pdf-line"></i> {{ __('Download PDF') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="filterDepartment">{{ __('Filter by Department') }}</label>
                            <select id="filterDepartment" class="form-select">
                                <option value="all">{{ __('All') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->name }}">{{ ucwords($department->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="filterDesignation">{{ __('Filter by Designation') }}</label>
                            <select id="filterDesignation" class="form-select">
                                <option value="all">{{ __('All') }}</option>
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->name }}">{{ ucwords($designation->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table id="membersTable" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('Member Name') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr data-department="{{ $member->designation->department->name }}"
                                    data-designation="{{ $member->designation->name }}">
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->designation->name }}</td>
                                    <td>{{ $member->designation->department->name }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.members.show', $member->id) }}"
                                            class="btn btn-primary">
                                            {{ __('View Details') }}
                                        </a>
                                        <a href="{{ route('dashboard.reports.member.member', $member->id) }}"
                                            class="btn btn-primary">
                                            {{ __('View Productivities') }}
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
        function filterMembers() {
            var filterDepartment = document.getElementById('filterDepartment').value;
            var filterDesignation = document.getElementById('filterDesignation').value;

            var members = document.querySelectorAll('#membersTable tbody tr');

            members.forEach(function(member) {
                var department = member.getAttribute('data-department');
                var designation = member.getAttribute('data-designation');

                var showMember = (filterDepartment === 'all' || filterDepartment === department) &&
                    (filterDesignation === 'all' || filterDesignation === designation);

                if (showMember) {
                    member.style.display = '';
                } else {
                    member.style.display = 'none';
                }
            });
        }

        document.getElementById('filterDepartment').addEventListener('change', filterMembers);
        document.getElementById('filterDesignation').addEventListener('change', filterMembers);

        document.getElementById('downloadPdfBtn').addEventListener('click', function(e) {
            e.preventDefault();

            var department = document.getElementById('filterDepartment').value;
            var designation = document.getElementById('filterDesignation').value;

            var url = "{{ route('dashboard.members.pdf') }}" + "?department=" + department + "&designation=" +
                designation;

            window.location.href = url;
        });
    </script>
@endsection
