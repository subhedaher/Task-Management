@extends('dashboard.reports.parent')

@section('title', 'Projects')

@section('content')
    <h1>{{ __('Projects Report') }}</h1>
    <table>
        <thead>
            <tr>
                <th>{{ __('Project Name') }}</th>
                <th>{{ __('Start Date') }}</th>
                <th>{{ __('End Date') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Priority') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ dateFormate2($project->start_date) }}</td>
                    <td>{{ dateFormate2($project->end_date) }}</td>
                    <td>
                        {{ $project->status }}
                    </td>
                    <td>
                        {{ $project->priority }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
