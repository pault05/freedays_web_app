@extends('Components.layout')

@section('content')

    <div class="card p-3 shadow-sm mb-5 text-center">
        <h1>Home Page</h1>
    </div>


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
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
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            #calendar {
                width: 100%;
                height: 100%;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adding shadow around the calendar */
                border-radius: 8px; /* Adding rounded corners */
                padding: 20px; /* Adding padding to match the heading */
                background: white; /* White background for the calendar */
            }

            .fc-day-sat, .fc-day-sun {
                background-color: #f0f0f0;
                border: 1px solid #d0d0d0;
            }

            .fc-holiday {
                background-color: #ffdddd;
                border: 1px solid #ff0000;
            }
            .fc-additional-event {
                background-color: #cee65a;
                border: 1px solid #000000;
            }
        </style>
    </head>
    <body>

        <div id="calendar-container">
            <div id='calendar'></div>
        </div>

    <footer>
        <div class="d-flex container justify-content-end" style="width: 99%">
            <button class="btn btn-primary ms-3">Contact</button>
            <button class="btn btn-primary ms-3">Internal Conduit</button>
        </div>
    </footer>

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
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Fetch holidays
                        fetch('/holidays')
                            .then(response => response.json())
                            .then(holidayData => {
                                const holidayEvents = holidayData.map(holiday => ({
                                    title: holiday.name,
                                    start: holiday.date,
                                    display: 'block',
                                    classNames: ['fc-holiday']
                                }));

                                // Fetch additional events
                                fetch('/free-days-request-json')
                                    .then(response => response.json())
                                    .then(additionalData => {
                                        const additionalEvents = additionalData.map(event => ({
                                            title: event.user_id,
                                            start: event.starting_date,
                                            end: event.ending_date,
                                            display: 'block',
                                            classNames: ['fc-additional-event'],
                                        }));

                                        // Merge holiday and additional events
                                        const allEvents = holidayEvents.concat(additionalEvents);

                                        // Pass the merged events to the calendar
                                        successCallback(allEvents);
                                    })
                                    .catch(error => {
                                        console.error('Error fetching free days:', error);
                                        failureCallback(error);
                                    });
                            })
                            .catch(error => {
                                console.error('Error fetching holidays:', error);
                                failureCallback(error);
                            });
                    }
                });
                calendar.render();
            });
        </script>



    </body>


@endsection

