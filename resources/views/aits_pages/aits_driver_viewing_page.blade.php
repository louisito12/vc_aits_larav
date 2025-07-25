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


    {{-- Modals --}}
    <!-- add user -->
    <div class="modal fade" id="file_upload_modal" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" id="fileUploadModalLabel">Upload Itinerary</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label>Request Number</label>
                            <input type="text" class="form-control spec_input" id="request_no" readonly>
                        </div>
                        <div class="col-4">
                            <label>Date Requested</label>
                            <input type="text" class="form-control spec_input" id="date_requested" readonly>
                        </div>
                        <div class="col-4">
                            <label>Destination</label>
                            <textarea class="form-control spec_input" disabled id="destination"></textarea>
                            <input type="text" id="hidden_id" hidden>



                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label>Client Name</label>
                            <input type="text" class="form-control spec_input" id="client_name" readonly>
                        </div>
                        <div class="col-4">
                            <label>Requestor Remarks</label>
                            <textarea class="form-control spec_input" disabled id="req_remarks"></textarea>
                        </div>
                        <div class="col-4">
                            <label>Driver Remarks</label>
                            <textarea class="form-control spec_input" disabled id="app_remarks"></textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-4">
                            <label>Departure Date</label>
                            <input type="datetime-local" class="form-control spec_input" disabled id="departure_date">
                        </div>
                        <div class="col-4">
                            <label>Appointment Date</label>
                            <input type="datetime-local" class="form-control spec_input" disabled id="apointment_date">
                        </div>
                        <div class="col-4">
                            <label>Pick Up Date</label>
                            <input type="datetime-local" class="form-control spec_input" disabled id="pick_up_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label>Upload Itinerary</label>
                            <input type="file" class="form-control spec_input" id="upload_file">

                        </div>
                        <div class="col-6">
                            <label>Upload Remarks</label>
                            <textarea class="form-control spec_input" id="upload_remarks" placeholder="Enter remarks here..."></textarea>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="upload_btn" class="btn btn-primary">Upload</button>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="show_shuttle_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id=""> View Vehicle Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row purpose_row">
                        <div class="col-2 purpose_col">
                            <label>Departure Date</label>
                            <input type="text" hidden id="show_id" class="spec_input form-control ">

                            <input disabled type="datetime-local" id="show_departure_date"
                                class="spec_input form-control ">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Appointment Date</label>
                            <input disabled type="datetime-local" id="show_appointment_date"
                                class="spec_input form-control">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Pick Up Date</label>
                            <input disabled type="datetime-local" id="show_pick_up_date" class="spec_input form-control">
                        </div>
                        <div class="col-4 purpose_col">
                            <label>Purpose</label>
                            <select disabled name="" class="form-control spec_input" id="show_type">
                                <option value="">Please Select Purpose</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->type }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>

                        <div class="col-2 show_purpose_column_hidden">
                            <label for="manager_app">Other Purpose</label>
                            <input disabled type="text" id="show_purpose" class="form-control spec_input">
                        </div>

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Destination</label>
                            <textarea disabled class="form-control" id="show_destination"></textarea>
                        </div>
                        <div class="col-6">
                            <label>Remarks</label>
                            <textarea disabled class="form-control" id="show_remarks"></textarea>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-3">
                            <label>Client Name</label>
                            <input disabled type="text" id="show_client_name" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Number of Passengers</label>
                            <input disabled type="number" id="show_passenger_number" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Manager</label>
                            <input disabled type="text" id="show_manager_id" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Requestor Name</label>
                            <input disabled type="text" id="show_requestor" class="form-control">
                        </div>
                        <div hidden class="col-3">
                            <label>OB Form</label>
                            <input type="file" id="show_ob_form" class="form-control spec_input">
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Request Status</label>
                            <input disabled type="text" class="form-control" id="show_req_stats">
                        </div>
                        <div class="col-4">
                            <label>Approved By</label>
                            <input disabled type="text" class="form-control" id="show_approver">

                        </div>
                        <div class="col-4">
                            <label>Approved Date</label>
                            <input disabled type="text" class="form-control" id="show_approve_date">

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Driver</label>
                            <input type="text" disabled class="form-control spec_input" id="show_driver">
                        </div>

                        <div class="col-4">
                            <label>Vehicle</label>
                            <input type="text" disabled class="form-control spec_input" id="show_vehicle">
                        </div>

                        <div class="col-4">
                            <label>Approve Remarks</label>
                            {{-- <input type="text" disabled class="form-control spec_input" id="app_remarks"> --}}

                            <textarea disabled name="" class="form-control spec_input" id="app_remarks_text"></textarea>
                        </div>
                    </div>

                    <br><br>
                    <div class="row driver_row">
                        <div class="col-6">
                            <label>Driver Remarks</label>
                            <textarea class="form-control spec_input" disabled id="driver_remarks"></textarea>
                        </div>

                        <div class="col-6">
                            <label>Driver File</label>
                            <div id="driver_file">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
                dom: 'Bfrtip',
                buttons: [

                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text: 'PDF',
                        title: 'Messenger Logistics Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],

                columns: get_columns(),

            });

            $(document).on('click', '.btn_show_data', function() {
                $('.driver_row').attr('hidden', true);
                $.ajax({
                    url: "retrieve_shuttle_request/" + $(this).data('id'),
                    type: "GET",
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return
                        }

                        $('#show_shuttle_modal').modal('show');
                        $('#show_id').val(e['data']['id']);
                        $('#show_departure_date').val(e['data']['departure_date']);
                        $('#show_appointment_date').val(e['data']['appointment_date']);
                        $('#show_pick_up_date').val(e['data']['pick_up_date']);
                        $('#show_type').val(e['data']['type']);
                        $('#show_purpose').val(e['data']['purpose']);
                        $('#show_destination').val(e['data']['destination']);
                        $('#show_remarks').val(e['data']['remarks']);
                        $('#show_client_name').val(e['data']['client_name']);
                        $('#show_passenger_number').val(e['data']['passenger_number']);
                        $('#show_manager_id').val(e['data']['manager_id']);
                        $('#show_passenger_number').val(e['data']['passenger_number']);
                        $('#view_data_header').text('View Shuttle Request  #' + e['data'][
                            'request_number'
                        ])
                        $('#show_requestor').val(e['data']['get_requestor_data']['firstname'] +
                            ' ' + e['data']['get_requestor_data']['lastname']);
                        $('#show_manager_id').val(e['data']['get_manager_data']['firstname'] +
                            ' ' +
                            e['data']['get_manager_data']['lastname']);
                        $('#show_req_stats').val(e['data']['status'] == 0 ? 'Cancelled' : e[
                            'data'][
                            'request_status'
                        ]);

                        if (e['data']['request_status'] != 'Cancelled') {
                            $('#show_approver').val(e['data']['get_approver_data'] ? e['data'][
                                    'get_approver_data'
                                ]['firstname'] +
                                ' ' + e['data']['get_approver_data']['lastname'] : '');
                            $('#show_approve_date').val(e['data']['date_approved']);

                            $('#show_driver').val(
                                e['data']['get_driver_data'] ?
                                e['data']['get_driver_data']['fname'] + ' ' +
                                e['data']['get_driver_data']['lname'] :
                                ''
                            );

                            $('#show_vehicle').val(e['data']['get_car_data'] ? e['data'][
                                'get_car_data'
                            ]['plate_number'] : '');


                            $('#app_remarks_text').val(e['data']['driver_app_remarks']);


                            if (e['data']['driver_remarks']) {
                                $('.driver_row').removeAttr('hidden');
                                $('#driver_remarks').val(e['data']['driver_remarks'])
                                $('#driver_file').html(e['data']['driver_file'] ? e['data'][
                                    'driver_file'
                                ] : '');
                            }

                        }

                    }
                })




            })



            $(document).on('click', '.btn_upload', function() {
                var id = $(this).data('id');
                $('#file_upload_modal').modal('show');

                // $('#upload_file_modal').modal('show');
                // $('#upload_file_id').val(id);

                $.ajax({
                    url: "retrieve_shuttle_request/" + id,
                    type: "GET",
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return;
                        }


                        // departure_date
                        // appointment_date
                        // pick_up_date
                        // client_name
                        // date_approved
                        // date_created
                        // remarks
                        // get_app_remarks.remarks


                        $('#request_no').val(e['data']['request_number']);
                        $('#date_requested').val(e['data']['date_created']);
                        $('#departure_date').val(e['data']['departure_date']);
                        $('#apointment_date').val(e['data']['appointment_date']);
                        $('#pick_up_date').val(e['data']['pick_up_date']);
                        $('#destination').val(e['data']['destination']);
                        $('#client_name').val(e['data']['client_name']);
                        $('#req_remarks').val(e['data']['get_app_remarks']['remarks']);
                        $('#app_remarks').val(e['data']['driver_app_remarks']);
                        $('#hidden_id').val(e['data']['id']);


                    }
                });
            });
            $('#upload_btn').on('click', function() {
                const shuttle_id = $('#hidden_id').val();
                const upload_file = $('#upload_file').prop('files')[0];
                const upload_remarks = $('#upload_remarks').val();

                if (upload_file == undefined || upload_file == null || upload_file == '') {
                    alertify.error('<span style="color: white;">Upload file is required</span>');
                    return;
                }
                if (upload_remarks == undefined || upload_remarks == null || upload_remarks == '') {
                    alertify.error('<span style="color: white;">Remarks is required</span>');
                    return;
                }
                //create a fomr data  ajax to that
                const formData = new FormData();
                formData.append('id', shuttle_id);
                formData.append('file[]', upload_file);
                formData.append('driver_remarks', upload_remarks);


                $.ajax({
                    url: "{{ route('driver_upload_remarks') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + response['msg'] +
                                '</span>');
                            return;
                        }

                        $('#file_upload_modal').modal('hide');
                        $('#tbl_transit_tbl').DataTable().ajax.reload();
                        $('#upload_file').val('');
                        $('#upload_remarks').val('');

                        Swal.fire({
                            title: "Good job!",
                            text: "Successfully uploaded a file",
                            icon: "success"
                        });

                    },

                })
            });
        })
    </script>
@endsection
