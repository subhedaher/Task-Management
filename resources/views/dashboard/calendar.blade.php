@extends('dashboard.parent')

@section('title', __('Calendar'))

@section('main-title', __('Calendar'))

@section('page', __('Calendar'))

@section('content')
    <div id="calendar"></div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            var tasks = @json($tasks) || [];
            var projects = @json($projects) || [];

            function isValidDate(dateString) {
                var date = new Date(dateString);
                return !isNaN(date.getTime());
            }

            var taskEvents = tasks.map(function(task) {
                return {
                    title: task.name,
                    start: isValidDate(task.start_date) ? task.start_date : null,
                    end: isValidDate(task.end_date) ? task.end_date : null
                };
            }).filter(event => event.start !== null);

            var projectEvents = projects.map(function(project) {
                return {
                    title: project.name,
                    start: isValidDate(project.start_date) ? project.start_date : null,
                    end: isValidDate(project.end_date) ? project.end_date : null
                };
            }).filter(event => event.start !== null);

            var events = taskEvents.concat(projectEvents);

            var initialDate;
            if (events.length > 0) {
                var allDates = events.map(event => new Date(event.start));
                initialDate = new Date(Math.min.apply(null, allDates));
            } else {
                initialDate = new Date();
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: initialDate.toISOString().split('T')[0],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events,
            });

            calendar.render();
        });
    </script>
@endsection
