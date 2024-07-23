@extends('Components.layout')

@section('content')

    <div class="container-main d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
            <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">Home Page</h1>
        </div>
    </div>

{{--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}
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
                border: 1px solid #000000;
            }

            .fc-holiday {
                background-color: #878787;
                border: 1px solid #000000;
            }
            .fc-additional-event {
                background-color: #cee65a;
                border: 1px solid #000000;
            }
        </style>

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
                                        const additionalEvents = additionalData
                                            .filter(event => event.status === 'Approved')
                                            .map(event => {
                                            const endDate = new Date(event.ending_date);
                                            endDate.setDate(endDate.getDate() + 1);

                                            return {
                                                title: event.employee_name,
                                                start: event.starting_date,
                                                end: endDate.toISOString().split('T')[0],
                                                display: 'block',
                                                color: event.color,
                                                classNames: ['fc-additional-event'],
                                            }
                                        });

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

@endsection

