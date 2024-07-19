@extends('components.layout')

@section('content')

        <div class="mt-5">
            <h3 class="text-center mb-4">Request Free Days</h3>
        </div>

        <div class="container mt-2">
                <form action="/free-day-request/save" method="POST">
                    <div class="row">
                        @csrf
                            <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                                <label for="start-date">Start Date</label>
                                    <input type="date" class="form-control" name="start-date">
                            </div>
                            <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                                <label for="end-date">End Date</label>
                                    <input type="date" class="form-control"  name="end-date">
                            </div>

                            <div class="col-sm-1 col-md-2 col-lg-3 mb-2">
                                <label for="days-left">Days off left</label>
                                <input type="text" class="form-control" name="days-left" placeholder="Days off left">
                            </div>

                            <div class="col-sm-1 col-md-2 col-lg-3 form-check mt-1 mb-2">
                                 <br>
                                <label class="form-check-label" for="half-day">Half day</label>
                                <input type="checkbox" class="form-check-input" name="half-day">
                            </div>

                            <div class="mb-3 row mb-2">
                                <label for="category" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select class="form-select"  name="category">
                                        <option selected>Choose category...</option>
                                        <option value="1">Paid Leave</option>
                                        <option value="2">Unpaid Leave</option>
                                        <option value="3">Medical Leave</option>
                                        <option value="4">Motivated Leave</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control"  name="description" rows="3" placeholder="Description"></textarea>
                            </div>

                            <div class="mb-2 row">
                                <label for="file-upload" class="col-sm-2 col-form-label">Choose a file</label>
                                <div class="col-sm-4">
                                    <input type="file" class="form-control" name="file-upload">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary">Back</button>
                                <button type="submit" class="btn btn-primary ms-3">Submit</button>
                            </div>
                    </div>
                </form>
               </div>
        </div>

@endsection
