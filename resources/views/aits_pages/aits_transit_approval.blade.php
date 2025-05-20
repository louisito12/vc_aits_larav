@extends('aits_main_page')



@section('content')


    <style>
        #tbl_transit th,
        #tbl_transit td {
            text-align: center !important;
            vertical-align: middle;
            font-size: 0.8em;
            /* Adjust this value as needed */
        }
    </style>
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Shuttle Request Approval</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Service Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shuttle Request</li>
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


                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="tbl_transit" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Request #</th>
                                        <th>Date Requested</th>
                                        <th>Departure Date</th>
                                        <th>Appointment Date</th>
                                        <th>Pick Up Date</th>
                                        <th>Distanation</th>
                                        <th>Requested By</th>
                                        <th>Type</th>
                                        <th>OB File</th>
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
    <!-- Show Data -->
    <div class="modal fade" id="show_shuttle_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="view_data_header"> View Shuttle Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row purpose_row">
                        <div class="col-2 purpose_col">
                            <label>Departure Date</label>
                            <input type="text" hidden id="show_id" class="spec_input form-control ">

                            <input disabled type="datetime-local" id="show_departure_date" class="spec_input form-control ">
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
                            <textarea disabled class="form-control" name="" id="show_destination"></textarea>
                        </div>
                        <div class="col-6">
                            <label>Remarks</label>
                            <textarea disabled class="form-control" name="" id="show_remarks"></textarea>
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
                        <div hidden class="col-3">
                            <label>OB Form</label>
                            <input type="file" id="show_ob_form" class="form-control spec_input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="approve_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="view_data_header"> Approve Shuttle Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <label>Driver</label>
                            <select name="" class="form-control" id="driver_id">
                                <option value="">Select Driver</option>
                                @foreach ($driver as $drivers)

                                    <option value="{{ $drivers->id }}">{{ $drivers->fname }} {{ $drivers->lname }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Car</label>
                            <select name="" class="form-control" id="car_id">
                                <option value="">Select Car</option>
                                @foreach ($car as $cars)

                                    <option value="{{ $cars->id }}">{{ $cars->plate_number}} </option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Brand</label>
                            <input readonly type="text" id="brand" class="form-control">
                        </div>
                        <div class="col-6">
                            <label>Model</label>
                            <input readonly id="model" type="text" class="form-control">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="approve_shuttle_btn" class="btn btn-success">Approve</button>


                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->





@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#tbl_transit').DataTable({
                ajax: {
                    url: "{{ route('get_approval_transit') }}",

                },
                columns: [
                    {
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
                        data: "status"
                    },



                    {
                        data: "admin_action"
                    },
                ]
            });


            $(document).on('click', '.btn_approved', function () {
                // alert($(this).data('val'));

                if ($(this).data('val') == 1) {
                    //approve
                    $('#model').val('');
                    $('#brand').val('');
                    $('#driver_id').val('');
                    $('#car_id').val('');
                    $('#approve_modal').modal('show');

                    // Swal.fire({
                    //     title: 'Are you sure?',
                    //     text: 'Do you want to proceed?',
                    //     icon: 'warning',
                    //     showCancelButton: true,
                    //     confirmButtonText: 'Yes, proceed',
                    //     cancelButtonText: 'No, cancel'
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         Swal.fire({
                    //             title: 'Please enter your reason',
                    //             input: 'text',
                    //             inputLabel: 'Reason For Disapprove',
                    //             inputPlaceholder: 'Type your reason here...',
                    //             showCancelButton: true,
                    //             confirmButtonText: 'Submit',
                    //             cancelButtonText: 'Cancel',
                    //             inputValidator: (value) => {
                    //                 if (!value) {
                    //                     return 'You need to enter a reason for disapprove!';
                    //                 }
                    //             }
                    //         }).then((inputResult) => {
                    //             if (inputResult.isConfirmed) {
                    //                 Swal.fire({
                    //                     title: 'You entered:',
                    //                     text: inputResult.value,
                    //                     icon: 'info'
                    //                 });
                    //             }
                    //         });
                    //     }
                    // });




                }
                if ($(this).data('val') == 2) {
                    //dissapproved

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You want to disapprove this request?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "disapprove_shuttle/" + $(this).data('id'),
                                success: function (e) {
                                    Swal.fire({
                                        title: "Disapproved!",
                                        text: "Your file has been Disapproved.",
                                        icon: "success"
                                    });
                                    $('#tbl_transit').DataTable().ajax.reload();
                                }
                            })

                        }
                    });
                }



            });


            $(document).on('click', '.btn_show_data', function () {

                $.ajax({
                    url: "retrieve_shuttle_request/" + $(this).data('id'),
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
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
                        $('#view_data_header').text('View Shuttle Request  #' + e['data']['request_number'])

                    }
                })
            })




            $('#car_id').change(function () {
                $.ajax({
                    url: "get_car_details/" + $(this).val(),
                    success: function (e) {
                        $('#model').val(e['data']['model'])
                        $('#brand').val(e['data']['brand'])

                    }
                })
            })




        })
    </script>
@endsection