@extends('aits_main_page')



@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Room Request</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Service Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Room Reservation</li>
                </ol>
            </nav>
        </div>


    </div>
    <style>
        #room_request_tbl th,
        #room_request_tbl td {
            text-align: center !important;
            vertical-align: middle;
        }


        .alertify-logs {
            z-index: 999999 !important;
        }
    </style>


    <!-- Page Header Close -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Room Request</div>
                    <button id="add_request_btn" class="btn btn-success m-3">Add Request</button>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="room_request_tbl" class="table table-bordered text-nowrap table-sm w-100 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Request #</th>
                                    <th class="text-center">Request Room</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Date From</th>
                                    <th class="text-center">Date To</th>
                                    <th class="text-center">Event/Purpose</th>
                                    <th class="text-center">Date Requested</th>
                                    <th class="text-center">Request Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script></script>
@endsection
