@extends('Components.layout')

@section('content')

    <div class="card p-3 shadow-sm mb-5">
        <h1>Home Page</h1>
    </div>


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scrollable List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
        <style>
            body {
                display: flex;
                flex-direction: column;
                height: 100vh;
                margin: 0;
            }
            .container-fluid {
                display: flex;
                flex: 1;
                padding: 0;
                overflow: hidden;
            }
            #list-example {
                width: 200px;
                overflow-y: auto;
                background-color: #f8f9fa;
                border-right: 1px solid #dee2e6;
                padding-top: 20px;
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
            #calendar-container {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
            }
            #calendar {
                width: 100%;
                height: 100%;
            }

            .fc-day-sat, .fc-day-sun {
                background-color: #f0f0f0;
                border: 1px solid #d0d0d0;
            }

            .fc-holiday {
                background-color: #ffdddd;
                border: 1px solid #ff0000;
            }
        </style>
    </head>
    <body>

    <div class="container-fluid">
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


        <div id="calendar-container">
            <div id='calendar'></div>
        </div>
    </div>

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

