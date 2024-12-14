@extends('dashboard.reports.parent')

@section('title', 'Tasks')

@section('content')

    <h1>{{ __('Tasks Report') }}</h1>
    <table>
        <thead>
            <tr>
                <th>{{ __('Task Name') }}</th>
                <th>{{ __('Start Date') }}</th>
                <th>{{ __('End Date') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Priority') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ dateFormate2($task->start_date) }}</td>
                    <td>{{ dateFormate2($task->end_date) }}</td>
                    <td>
                        {{ $task->status }}
                    </td>
                    <td>
                        {{ $task->priority }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
