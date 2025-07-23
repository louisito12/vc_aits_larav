@extends('aits_main_page')



@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Itenerary Record</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Itenerary Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Itenerary Record</li>
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
                    <div class="card-title m-1 p-3">My Itenerary</div>

                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="tbl_transit_tbl" class="table table-bordered text-nowrap table-sm w-100 text-center">
                            <thead>
                                <tr>
                                <tr>
                                    <th>Request #</th>
                                    <th>Date Requested</th>
                                    <th>Departure Date</th>
                                    <th>Appointment Date</th>
                                    <th>Pick Up Date</th>
                                    <th>Destination</th>
                                    <th>Requested By</th>
                                    <th>Type</th>
                                    <th>OB File</th>
                                    <th>Status</th>
                                    <th>Driver</th>
                                    <th>Vehicle</th>

                                    <th>Action</th>
                                </tr>
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
    <script>
        $(document).ready(function() {
            function get_columns() {
                return [{
                        data: "request_no"
                    },
                    {
                        data: "date_created"
                    },
                    {
                        data: "departure_date"
                    },
                    {
                        data: "appointment_date"
                    },
                    {
                        data: "pick_up_date"
                    },
                    {
                        data: "destination"
                    },
                    {
                        data: "reuqeusted_by"
                    },
                    {
                        data: "type"
                    },
                    {
                        data: "action_file",
                        // createdCell: function (td, cellData, rowData, row, col) {
                        //     $(td).css({
                        //         'max-width': '1000px',
                        //         'white-space': 'pre-wrap',
                        //         'text-align': 'center',
                        //     });
                        // },
                    },
                    {
                        data: "status_html"
                    },
                    {
                        data: "driver"
                    },
                    {
                        data: "vehicle"
                    },


                    {
                        data: "driver_action"
                    },
                ]
            }



            $('#tbl_transit_tbl').DataTable({
                destroy: true,
                ajax: {
                    url: "{{ route('driver_data') }}",
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                },

                columns: get_columns(),

            });

            $(document).on('click', '.btn_upload', function() {
                var id = $(this).data('id');
                alert(id);

                // $('#upload_file_modal').modal('show');
                // $('#upload_file_id').val(id);
            });
        })
    </script>
@endsection
