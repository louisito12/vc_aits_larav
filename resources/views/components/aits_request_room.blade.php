@extends('apps')


@section('section')


    <div class="pagetitle">
        <h1>Room Reservations Requests</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data</li>
            </ol>

        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <h5 class="card-title">Reserve Room Schedule</h5>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-2">
                                <br>
                                <button id="btn_add" class="btn btn-success spec_input">Request Room</button>

                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="tbl_file" class="table table-bordered table-striped spec_input">
                                        <thead>

                                            <tr>
                                                <th scope="col">Room and Floor</th>
                                                <th scope="col">Date and Time</th>
                                                <th scope="col">End Date Time</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Requestor</th>
                                                <th scope="col" style="min-width: 100px">Action</th>
                                            </tr>

                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection





<!-- Modals -->