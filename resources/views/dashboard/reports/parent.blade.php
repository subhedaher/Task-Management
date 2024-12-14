<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ __('Report') }} | @yield('title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            vertical-align: middle;
        }

        table {
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: #fff;
            display: inline-block;
        }

        .status-not-started {
            background-color: #f0ad4e;
        }

        .status-in-progress {
            background-color: #5bc0de;
        }

        .status-completed {
            background-color: #5cb85c;
        }

        .priority-low {
            background-color: #5bc0de;
        }

        .priority-medium {
            background-color: #f0ad4e;
        }

        .priority-high {
            background-color: #d9534f;
        }
    </style>
</head>

<body>
    <div style="text-align: left;">
        <strong>{{ date('Y M d') }}</strong>
    </div>
    <div style="text-align: left;">
        <strong>{{ date('H:i:s') }}</strong>
    </div>
    @yield('content')
</body>

</html>
