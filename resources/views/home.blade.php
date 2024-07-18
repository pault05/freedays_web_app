@extends('Components.layout')

@section('content')

{{--    <div class="mb-3">--}}
{{--        <form action="/user-profile" method="GET">--}}
{{--            <input type="submit" value="User Profile"  />--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <div class="mb-3">--}}
{{--        <form action="/free-day-request" method="GET">--}}
{{--            <input type="submit" value="Free Day Request" />--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <div class="mb-3">--}}
{{--        <form action="/account-creation" method="GET">--}}
{{--            <input type="submit" value="Create a New Account" />--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <div class="mb-3">--}}
{{--        <form action="/admin-view" method="GET">--}}
{{--            <input type="submit" value="Admin Dashboard" />--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <div class="mb-3">--}}
{{--        <form action="/login" method="POST">--}}
{{--            <input type="submit" value="Login" />--}}
{{--        </form>--}}
{{--    </div>--}}


    <div class="card p-3 shadow-sm mb-5">
        <h1>Home Page</h1>
    </div>

<div class="container">
    <div id='calendar'></div>
</div>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scrollable List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
        <style>
            #list-example {
                position: fixed;
                top: 0;
                left: 0;
                width: 200px;  /*width*/
                height: 100%;
                overflow-y: auto;
                background-color: #f8f9fa; /* background color */
                border-right: 1px solid #dee2e6; /* Border */
                padding-top: 20px; /*padding at the top */
            }
            .list-group-item {
                border: none;
                padding: 0;
            }
            .btn-link {
                width: 100%;
                text-align: left;
                padding: 10px 15px;
                border: none;
                background: none;
                font-weight: 400;
                color: #007bff;
            }
            .btn-link:hover {
                color: #0056b3;
                text-decoration: none;
            }

            #calendar-container
            {
                width: 80%; /* width */
                height: 600px; /* height */
                margin: 0 auto; /* center */
                padding-top: 20px;
            }
            #calendar {
                height: 100%;
            }

            .fc-day-sat, .fc-day-sun {
                background-color: #f0f0f0; /* Light gray background */
                border: 1px solid #d0d0d0; /* Light gray border */
            }

            .fc-holiday {
                background-color: #ffdddd; /* Light red background */
                border: 1px solid #4326ac; /* Red border */
            }

        </style>
    </head>
    <body>

    <div id="list-example" class="list-group">
        <form class="list-group-item list-group-item-action" method="get" action="/user-profile">
            <button type="submit" class="btn btn-link">User Profile</button>
        </form>
        <form class="list-group-item list-group-item-action" method="get" action="/free-day-request">
            <button type="submit" class="btn btn-link">Free Day Request</button>
        </form>
        <form class="list-group-item list-group-item-action" method="get" action="/account-creation">
            <button type="submit" class="btn btn-link">Create A New Account</button>
        </form>
        <form class="list-group-item list-group-item-action" method="get" action="/admin-view">
            <button type="submit" class="btn btn-link">Admin Dashboard</button>
        </form>
        <form class="list-group-item list-group-item-action" method="post" action="/login">
            <button type="submit" class="btn btn-link">Login</button>
        </form>
    </div>
'

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                firstDay: 1, // Set Monday as the first day of the week
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                dayCellClassNames: function(arg) {
                    if (arg.date.getDay() === 0 || arg.date.getDay() === 6) {
                        return ['fc-day-weekend'];
                    }
                    return [];
                },
                events: {
                    url: '/holidays', // URL to fetch holidays from
                    method: 'GET',
                    failure: function() {
                        alert('There was an error while fetching holidays!');
                    },
                    success: function(data) {
                        data.forEach(function(holiday) {
                            calendar.addEvent({
                                title: holiday.name,
                                start: holiday.date,
                                display: 'background',
                                classNames: ['fc-holiday']
                            });
                        });
                    }
                }
            });
            calendar.render();
        });
    </script>





    </body>


@endsection


{{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                firstDay: 1, // first day of the week == monday
                dayCellClassNames: function(arg) {
                    if (arg.date.getDay() === 0 || arg.date.getDay() === 6) {
                        return ['fc-day-weekend'];
                    }
                    return [];
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                }
            });
            calendar.render();
        });
    </script>


--}}
