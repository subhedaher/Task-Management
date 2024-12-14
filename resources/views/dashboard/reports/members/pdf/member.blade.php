@extends('dashboard.reports.parent')

@section('title', 'Members')

@section('content')

    <h1>{{ __('Members Report') }}</h1>
    <table>
        <thead>
            <tr>
                <th>{{ __('Member') }}</th>
                <th>{{ __('Designation') }}</th>
                <th>{{ __('Department') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Phone') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->designation->name }}</td>
                    <td>{{ $member->designation->department->name }}</td>
                    <td>{{ $member->address }}</td>
                    <td>{{ $member->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
