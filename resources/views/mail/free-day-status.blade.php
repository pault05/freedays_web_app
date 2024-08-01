<!DOCTYPE html>
<html>
<head>
    <title>New Free Day Request</title>
</head>
<body>
<h1>New Free Day Request</h1>
<p>Dear {{ $user->first_name }},</p>

<p>You have received a new mail</p>

 <li>Your request day for date {{ $day->starting_date }} - {{ $day->ending_date }} is <strong> {{ $stats }}</strong>.</li>
<h2>Days Off Left</h2>
<p>Days off left: {{ $daysOffLeft }}</p>

<p>
    <a href="{{ url('/home') }}">View your home page.</a>
</p>

<p>Thank you!</p>
</body>
</html>