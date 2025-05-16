@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Transit Request</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Service Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transit Request</li>
                </ol>
            </nav>
        </div>


    </div>


    <!-- Page Header Close -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Shuttle Request</div>
                    <button id="add_request_btn" class="btn btn-success m-3 ">Add Request</button>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="tbl_transit" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Date Requested</th>
                                        <th>Requested By</th>
                                        <th>Department</th>
                                        <th>Date Schedule</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Page modal -->

    <div class="modal fade" id="add_transit_room" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Shuttle Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-3">
                            <label>Date Departure</label>
                            <input type="text" class="spec_input form-control ">
                        </div>
                        <div class="col-3">
                            <label>Appointment Date</label>
                            <input type="text" class="spec_input form-control">
                        </div>
                        <div class="col-3">
                            <label>Date Departure</label>
                            <input type="text" class="spec_input form-control">
                        </div>
                        <div class="col-3">
                            <label>Appointment Date</label>
                            <input type="text" class="spec_input form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save_shuttle_btn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal end -->





@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#tbl_transit').DataTable();

            $('#add_request_btn').click(function () {
                $('#add_transit_room').modal('show');
            });

            $('#save_shuttle_btn').click(function () {

            });
        });
    </script>

@endsection