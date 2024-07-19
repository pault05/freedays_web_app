@extends('components.layout')

@section('content')

        <div class="mt-5">
            <h3 class="text-center mb-4">Request Free Days</h3>
        </div>
        <br>

        <div class="container mt-3">
                <form action="/free-day-request/save" method="POST">
                    <div class="row">
                        <div class="col-sm-1 col-md-2 col-lg-3 mb-3">
                            <label for="days-left">Days off left</label>
                            <p class="ms-1">5</p>
                        </div>
                    </div>
                    <div class="row">
                        @csrf
                        <div class="col-sm-1 col-md-2 col-lg-3 mb-2 w-25">
                                <label for="start-date">Start Date</label>
                            <div class="row w-75 ms-0">
                                    <input type="date" class="form-control" name="start-date">
                            </div>
                            </div>
                            <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                                <label for="end-date">End Date</label>
                                <div class="row w-75">
                                    <input type="date" class="form-control"  name="end-date">
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                                <label for="days-left">Selected leave days</label>
                                <div class="row w-75">
                                    <input type="text" class="form-control" name="days-left" placeholder="Selected leave days">
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-2 col-lg-3 form-check mt-1 mb-2 ">
                                 <br>
                                <label class="form-check-label" for="half-day">Half day</label>
                                <input type="checkbox" class="form-check-input " name="half-day">
                            </div>
                    </div>

                    <div class="row">
                                <div class="mb-3 col mb-2">
                                    <label for="category" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <select class="form-select"  name="category" style="width: 70vw">
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
                                <textarea class="form-control"  name="description" rows="3" placeholder="Description" style="width:70vw"></textarea>
                            </div>
                    </div>

                    <div class="row mt-3">
                            <div class="mt-3 row">
                                <div class="col-sm-4">
                                    <input type="file" class="form-control mb-1" name="file-upload">
                                </div>
                            </div>
                    </div>
                    <div class="row ms-1 mt-4">
                            <div class="d-flex justify-content-end" style="margin-left: 5.5%">
                                <a href="/home" type="button" class="btn btn-primary">Back</a>
                                <button type="submit" class="btn btn-primary ms-3">Submit</button>
                            </div>
                    </div>
                </form>
        </div>
@endsection

