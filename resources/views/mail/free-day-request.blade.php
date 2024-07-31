<!DOCTYPE html>
<html>
<head>
    <title>New Free Day Request</title>
</head>
<body>
<h1>New Free Day Request</h1>
<p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
{{--ATENTIE LA ADMIN-USER !!!--}}

<p>A new free day request has been submitted by {{$admin->first_name}} {{$admin->last_name}}.</p>
{{--ATENTIE LA ADMIN-USER !!!--}}

<h2>Request Details</h2>
<ul>
    <li>Request Starting Date: {{ $freeDayRequest->starting_date }}</li>
    <li>Request Ending Date: {{ $freeDayRequest->ending_date }}</li>
    <li>Days: {{ $freeDayRequest->days }}</li>
    <li>Description: {{ $freeDayRequest->description }}</li>
    <!-- Alte detalii aici -->
</ul>
<p>
    <a href="{{ url('/home') }}">View your home page.</a>
</p>

<p>Thank you!</p>
</body>
</html>
