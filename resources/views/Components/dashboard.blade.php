<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>

<div class="main-container d-flex">
    <div class="left-container" style="height: 100vh; color: #1a202c; width: 300px; background-color: #1a202c">
        <div class="container-fluid"  style="background-color: #1a202c; margin-top: 45%; width: 100%">
            <div id="list-example" class="list-group" style="background-color: #1a202c">
                <form class="list-group-item list-group-item-action mt-2" method="get" action="/user-profile"  style="background-color: #1a202c">
                    <button type="submit" class="btn btn-link">User Profile</button>
                </form>
                <form class="list-group-item list-group-item-action" method="get" action="/free-day-request"  style="background-color: #1a202c">
                    <button type="submit" class="btn btn-link">Free Day Request</button>
                </form>
                <form class="list-group-item list-group-item-action" method="get" action="/account-creation"  style="background-color: #1a202c">
                    <button type="submit" class="btn btn-link">Create A New Account</button>
                </form>
                <form class="list-group-item list-group-item-action" method="get" action="/admin-view"  style="background-color: #1a202c">
                    <button type="submit" class="btn btn-link">Admin Dashboard</button>
                </form>
                <form class="list-group-item list-group-item-action" method="get" action="/official-holiday"  style="background-color: #1a202c">
                    <button type="submit" class="btn btn-link">Official Holiday</button>
                </form>
                <form class="list-group-item list-group-item-action" method="get" action="/login"  style="background-color: #1a202c">
                    <button type="submit" class="btn btn-link">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


