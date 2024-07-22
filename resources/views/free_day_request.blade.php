<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request Free Days</title>
</head>
<body>

@extends('components.layout')

@section('content')

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    <div class="mt-5">
        <h3 class="text-center mb-4">Request Free Days</h3>
    </div>
    <br>

    <div class="card p-5 shadow mb-5 w-100 col-sm-1 col-md-3">

        <div class="container mt-3">
            <form id="leave-form" action="/free-day-request/save" method="POST">
                <div class="row">
                    <div class="col-sm-1 col-md-2 col-lg-3 mb-3">
                        <label for="days-left">Days off left</label>
                        <p class="ms-1">{{ 21 - $request_leave['approved'] }}</p>
                    </div>
                </div>
                <div class="row">
                    @csrf
                    <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                        <label for="start-date">Start date</label>
                        <div class="row w-75">
                            <input type="date" class="form-control" id="start-date" name="start-date">
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                        <label for="end-date">End Date</label>
                        <div class="row w-75">
                            <input type="date" class="form-control" id="end-date" name="end-date">
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                        <label for="days-left">Selected leave days</label>
                        <input type="text" class="form-control"
                               value="{{ session('days_left', '0') }}" id="days-left" placeholder="Selected leave days" readonly>
                        <input type="hidden" class="form-control" name="days" id="days"
                               value="{{ session('days_left', '0') }}" placeholder="Selected leave days">
                    </div>
                    <div class="col-sm-1 col-md-2 col-lg-3 form-check mt-1 mb-2 ">
                        <br>
                        <label class="form-check-label" for="half-day">Half day</label>
                        <input type="checkbox" class="form-check-input" name="half-day">
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col mb-2">
                        <label for="category" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="category_id" style="width: 50vw">
                                <option selected>Choose category...</option>
                                <option value="1">Paid Leave</option>
                                <option value="2">Unpaid Leave</option>
                                <option value="3">Medical Leave</option>
                                <option value="4">Motivated Leave</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-2">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Description" style="width:50vw"></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="mt-3 row">
                        <div class="col-sm-4">
                            <input type="file" class="form-control mb-1" name="file-upload">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row ms-1 mt-5">
        <div class="d-flex justify-content-end" style="margin-left: 0">
            <a href="/home" type="button" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary ms-3" form="leave-form" id="submit">Submit</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        function calculateDays() {
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();
            var halfDay = $('#half-day');

            if (startDate && endDate) {
                var start = moment(startDate);
                var end = moment(endDate);
                var diffInDays = end.diff(start, 'days') + 1; // +1 pentru a include ultima zi

                $('#days-left').val(diffInDays);
                $('#days').val(diffInDays); // Setează valoarea în câmpul ascuns

                // Verifica dacă startDate este egal cu endDate și actualizează checkbox-ul
                if (startDate === endDate) {
                    halfDay.prop('checked', true);
                } else {
                    halfDay.prop('checked', false);
                }
            } else {
                $('#days-left').val('');
                $('#days').val('');
                halfDay.prop('checked', false);
            }
        }

        // Atașează funcția de calcul la evenimentele de schimbare a câmpurilor
        $('#start-date, #end-date').on('change', calculateDays);

    </script>

@endsection
</body>

</html>
