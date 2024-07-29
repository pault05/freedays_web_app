
@extends('components.layout')

@section('content')

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    <div class="d-flex flex-column justify-content-center align-items-center">

    <div class="card p-3 shadow-sm mb-5 w-50 mt-3 bg-primary">
        <h1 class="text-center w-auto" style="text-shadow: 2px 2px 4px black;color: white">Free Days Request</h1>
    </div>


    <br>

    <div class="card p-5 shadow mb-5 w-100 col-sm-1 col-md-3">

        <div class="container mt-3">
            <form id="leave-form" action="/free-day-request/save" method="POST"  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="days-left">Days off left</label>
                        <p class="ms-1">{{ 21 - $request_leave['approved'] }}</p>
                    </div>
                </div>
                <div class="row d-flex justify-content-start me-3">
                    @csrf
                    <div class="col-lg-3 col-sm-12 col-md-6 mb-2">
                        <label for="start-date">Start date</label>
                            <input type="date" class="form-control" id="start-date" name="start-date">
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
                        <label for="end-date">End Date</label>
                            <input type="date" class="form-control" id="end-date" name="end-date">
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
                        <label for="days-left">Selected leave days</label>
                        <input type="text" class="form-control"
                               value="{{ session('days_left', '0') }}" id="days-left" placeholder="Selected leave days" readonly>
                        <input type="hidden" class="form-control" name="days" id="days"
                               value="{{ session('days_left', '0') }}" placeholder="Selected leave days">
                    </div>
                    <div id="half-day-container" class="col-sm-12 col-md-6 col-lg-3 form-check mt-1 mb-2" style="display: none">
                        <br>
                        <input type="checkbox" class="form-check-input" name="half-day" id="half-day">
                        <label class="form-check-label" for="half-day">Half day</label>
                    </div>
                </div>

                <div id="error-message" class="alert alert-danger" style="display: none;"></div>


                <div class="row">
                    <div class="mb-3 col mb-2">
                        <label for="category" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="category_id" style="width: 110%">
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
                        <textarea class="form-control" name="description" rows="3" placeholder="Description" style="width:92%"></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="mt-3 row">
                        <div class="col-sm-6" style="width: 94.5%">
                            <input type="file" class="form-control mb-1" style="width: 100%" name="proof">
                        </div>
                    </div>
                </div>
                <style>
                    .btnOutline {
                        background-color: transparent;
                        border: none;
                        outline: 2px solid #1A7766;
                        color: #000000;
                        padding: 10px 20px;
                        text-decoration: none;
                        display: inline-block;
                        cursor: pointer;
                        border-radius: 5px;
                        height: 100%
                    }
                </style>
                <div class="row ms-5 mt-5">
                    <div class="d-flex justify-content-end" style="margin-left: 89%; width: 3%">
                        <a href="/home" type="button" class="btnOutline">Back</a>
                        <button type="submit" class="btn ms-3" form="leave-form" id="submit" style="background-color: #1A7766; color: #ffffff">Submit</button>
                    </div>
                </div>

{{--                <div class="row ms-5 mt-5">--}}
{{--                    <div class="d-flex justify-content-end" style="margin-left: 89%; width: 3%">--}}
{{--                        <a href="/home" type="button" class="btn btn-outline-dark">Back</a>--}}
{{--                        <button type="submit" class="btn btn-dark ms-3" form="leave-form" id="submit">Submit</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
       function calculateDays() {
           var startDate = $('#start-date').val();
           var endDate = $('#end-date').val();
           var halfDay = $('#half-day');
           var halfDayContainer = $('#half-day-container');
           var errorMessage = $('#error-message');

           if (startDate && endDate) {
               var start = moment(startDate);
               var end = moment(endDate);

               if (start.isAfter(end)) {
                   errorMessage.text("Starting date cannot be bigger than ending date").show();
                   $('#days-left').val('');
                   $('#days').val('');
                   halfDayContainer.hide();
                   halfDay.prop('checked', false);
                   return;
               } else {
                   errorMessage.hide();
               }


               var diffInDays = end.diff(start, 'days') + 1; // +1 pentru a include ultima zi

               $('#days-left').val(diffInDays);
               $('#days').val(diffInDays);

               // Verifica dacă startDate este egal cu endDate
               if (startDate === endDate) {
                   halfDayContainer.show(); //facem containerul vizibil
                   halfDay.prop('checked', false);
               } else {
                   halfDayContainer.hide();
                   halfDay.prop('checked', false);
               }
           } else {
               $('#days-left').val('');
               $('#days').val('');
               halfDayContainer.hide();
               halfDay.prop('checked', false);
               errorMessage.hide();
           }
       }
        $('#start-date, #end-date').on('change', calculateDays);
    </script>

@endsection
