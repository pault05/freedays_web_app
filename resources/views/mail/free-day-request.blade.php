<!DOCTYPE html>
<html>
<head>
    <title>New Free Day Request</title>
</head>
<body>
<h1>New Free Day Request</h1>
<p>Dear {{ $user->first_name }},</p>

<p>You have submitted a new free day request.</p>

<h2>Request Details</h2>
<ul>
    <li>Request Starting Date: {{ $freeDayRequest->starting_date }}</li>
    <li>Request Ending Date: {{ $freeDayRequest->ending_date }}</li>
    <li>Description: {{ $freeDayRequest->description }}</li>
    <!-- Include any other details you want -->
</ul>
<p>
    <a href="{{ url('/home') }}">View your home page.</a>
</p>

<p>Thank you!</p>
</body>
</html>

