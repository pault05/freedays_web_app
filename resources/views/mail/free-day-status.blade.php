<!DOCTYPE html>
<html>
<head>
    <title>Free Day Request Status</title>
</head>
<body>
<h1>Your free day request status.</h1>
<p>Dear {{ $user->first_name }},</p>

<p>You have received a new mail regarding your free day request.</p>

 <li>Your request day for date {{ $day->starting_date }} - {{ $day->ending_date }} is <strong> {{ $stats }}</strong>.</li>
<h2>Days Off Left</h2>
<p>Days off left: {{ $daysOffLeft }}</p>

<p>
    <a href="{{ url('/home') }}">View your home page.</a>
</p>

<p>Thank you!</p>
</body>
</html>
