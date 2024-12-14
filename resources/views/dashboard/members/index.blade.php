@extends('dashboard.parent')

@section('title', __('Members'))

@section('main-title', __('Members'))

@section('page', __('List Members'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('List Members') }}</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="#: activate to sort column descending" style="width: 10.4px;">
                                    #</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Member: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Member') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Department: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Department') }}</th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="buttons-datatables"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Designations: activate to sort column descending" style="width: 50.4px;">
                                    {{ __('Designations') }}</th>
                            
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Phone: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Phone') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Address: activate to sort column ascending"
                                    style="width: 134.4px;">{{ __('Address') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Role: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('Role') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 63.4px;">{{ __('Status') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Created At: activate to sort column ascending"
                                    style="width: 26.4px;">{{ __('Created At') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="buttons-datatables" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending"
                                    style="width: 42.4px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->designation->department->name }}</td>
                                    <td>{{ $member->designation->name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ Str::limit($member->address , 20) }}</td>
                                    <td>{{ $member->roles[0]->name ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $member->status ? 'success' : 'danger' }}-subtle text-{{ $member->status ? 'success' : 'danger' }}">{{ $member->statusActive }}</span>
                                    </td>
                                    <td>{{ dateFormate($member->created_at) }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li><a href="{{ route('dashboard.members.show', $member->id) }}"
                                                    class="dropdown-item edit-item-btn"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    {{ __('Show') }}</a></li>
                                                <li><a href="{{ route('dashboard.members.edit', $member->id) }}"
                                                        class="dropdown-item edit-item-btn"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        {{ __('Edit') }}</a></li>
                                                <li>
                                                    <form id="button-delete-{{ $member->id }}"
                                                        action="{{ route('dashboard.members.destroy', $member->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bx bx-trash me-1"></i> {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
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
    </script>
@endsection
