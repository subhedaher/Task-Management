<?php

use Carbon\Carbon;

if (!function_exists('dateFormate')) {
    function dateFormate($date)
    {
        return $date->diffForHumans();
    }
}

if (!function_exists('name')) {
    function name()
    {
        return auth(session('guard'))->user()->name;
    }
}

if (!function_exists('guard')) {
    function guard()
    {
        return session('guard');
    }
}

if (!function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}

if (!function_exists('dateFormate2')) {
    function dateFormate2($date)
    {
        return Carbon::parse($date)->format('d M, Y');
    }
}

if (!function_exists('getStatusBadgeClass')) {
    function getStatusBadgeClass($status)
    {
        switch ($status) {
            case 'completed':
                return 'bg-success-subtle text-success';
            case 'in-progress':
                return 'bg-warning-subtle text-warning';
            case 'pending':
                return 'bg-danger-subtle text-danger';
            case 'not-started':
                return 'bg-info-subtle text-info';
            default:
                return 'bg-secondary-subtle text-secondary';
        }
    }
}

if (!function_exists('getPriorityBadgeClass')) {
    function getPriorityBadgeClass($priority)
    {
        switch ($priority) {
            case 'high':
                return 'bg-danger text-white';
            case 'medium':
                return 'bg-warning text-dark';
            case 'low':
                return 'bg-success text-white';
            default:
                return 'bg-secondary text-dark';
        }
    }
}

if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}


if (!function_exists('notUserImage')) {
    function notUserImage()
    {
        return asset('assets/images/user-dummy.jpg');
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($dateString)
    {
        return Carbon::parse($dateString)->format('Y M d - h:i A');
    }
}
