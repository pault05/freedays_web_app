<!DOCTYPE html>
<html>
<head>
    <title>New Free Day Request</title>
</head>
<body>
<h1>New Free Day Request</h1>
<p>Dear {{ $user->first_name }},</p>

<p>You have received a new mail</p>

<h2>Approved Requests</h2>
<ul>
    @foreach ($approvedDays as $day)
        <li>Your request day for date {{ $day->starting_date }} - {{ $day->ending_date }} is <strong>approved</strong>.</li>
    @endforeach
</ul>

<h2>Denied Requests</h2>
<ul>
    @foreach ($deniedDays as $day)
        <li>Your request day for date {{ $day->starting_date }} - {{ $day->ending_date }} is <strong>denied</strong>.</li>
    @endforeach
</ul>

<h2>Days Off Left</h2>
<p>Days off left: {{ $daysOffLeft }}</p>

<p>
    <a href="{{ url('/home') }}">View your home page.</a>
</p>

<p>Thank you!</p>
</body>
</html>


