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
            <h5 class="page-title fs-21 mb-1">Shuttle Request</h5>
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
                    <button id="add_request_btn" class="btn btn-success m-3 ">Add Request</button>

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
    <div class="modal fade" id="add_transit_room" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Shuttle Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row purpose_row">
                        <div class="col-2 purpose_col">
                            <label>Departure Date</label>
                            <input type="datetime-local" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00"
                                max="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}T00:00" id="departure_date"
                                class="spec_input form-control ">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Appointment Date</label>
                            <input type="datetime-local" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00"
                                max="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}T00:00" id="appointment_date"
                                class="spec_input form-control">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Pick Up Date</label>

                            <input type="datetime-local" id="pickup_date"
                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00"
                                max="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}T00:00"
                                class="spec_input form-control">
                        </div>
                        <div class="col-4 purpose_col">
                            <label>Purpose</label>
                            <select name="" class="form-control spec_input" id="purpose">
                                <option value="">Please Select Purpose</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->type }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>

                        <div hidden class="col-2 purpose_column_hidden">
                            <label for="manager_app">Other Purpose</label>
                            <input type="text" id="other_purpose" class="form-control spec_input">
                        </div>

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Destination</label>
                            <textarea class="form-control" name="" id="destination"></textarea>
                        </div>
                        <div class="col-6">
                            <label>Remarks</label>
                            <textarea class="form-control" name="" id="remarks"></textarea>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-3">
                            <label>Client Name</label>
                            <input type="text" id="client_name" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Number of Passengers</label>
                            <input type="number" id="number_pass" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Manager</label>
                            <input type="text" id="manager_app" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>OB Form</label>
                            <input type="file" id="ob_form_file" class="form-control spec_input">
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





    <div class="modal fade" id="edit_shuttle_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Shuttle Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row purpose_row">
                        <div class="col-2 purpose_col">
                            <label>Departure Date</label>
                            <input type="text" hidden id="edit_id" class="spec_input form-control ">

                            <input type="datetime-local" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00"
                                max="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}T00:00" id="edit_departure_date"
                                class="spec_input form-control ">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Appointment Date</label>
                            <input type="datetime-local" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00"
                                max="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}T00:00"
                                id="edit_appointment_date" class="spec_input form-control">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Pick Up Date</label>
                            <input type="datetime-local" id="edit_pick_up_date"
                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00"
                                max="{{ Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}T00:00"
                                class="spec_input form-control">
                        </div>
                        <div class="col-4 purpose_col">
                            <label>Purpose</label>
                            <select name="" class="form-control spec_input" id="edit_type">
                                <option value="">Please Select Purpose</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->type }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>

                        <div class="col-2 edit_purpose_column_hidden">
                            <label for="manager_app">Other Purpose</label>
                            <input type="text" id="edit_purpose" class="form-control spec_input">
                        </div>

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Destination</label>
                            <textarea class="form-control" name="" id="edit_destination"></textarea>
                        </div>
                        <div class="col-6">
                            <label>Remarks</label>
                            <textarea class="form-control" name="" id="edit_remarks"></textarea>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-3">
                            <label>Client Name</label>
                            <input type="text" id="edit_client_name" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Number of Passengers</label>
                            <input type="number" id="edit_passenger_number" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>Manager</label>
                            <input type="text" id="edit_manager_id" class="form-control spec_input">
                        </div>
                        <div class="col-3">
                            <label>OB Form</label>
                            <input type="file" id="edit_ob_form" class="form-control spec_input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_shuttle_btn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="show_shuttle_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id=""> View Shuttle Request
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



    <!-- Modal end -->





@endsection


@section('scripts')

    <script>
        $(document).ready(function () {

            function retrieve_shuttle(id, procedure) {
                $.ajax({
                    url: "retrieve_shuttle_request/" + id,
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return
                        }

                        if (procedure == "edit_data") {
                            $('#edit_shuttle_modal').modal('show');
                            $('#edit_id').val(e['data']['id']);
                            $('#edit_departure_date').val(e['data']['departure_date']);
                            $('#edit_appointment_date').val(e['data']['appointment_date']);
                            $('#edit_pick_up_date').val(e['data']['pick_up_date']);
                            $('#edit_type').val(e['data']['type']);
                            $('#edit_purpose').val(e['data']['purpose']);
                            $('#edit_destination').val(e['data']['destination']);
                            $('#edit_remarks').val(e['data']['remarks']);
                            $('#edit_client_name').val(e['data']['client_name']);
                            $('#edit_passenger_number').val(e['data']['passenger_number']);
                            $('#edit_manager_id').val(e['data']['manager_id']);

                        }

                        if (procedure == "show_data") {
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
                            $('#show_manager_id').val(e['data']['manager_id']);
                            $('#view_data_header').text('View Shuttle Request  #' + e['data']['request_number'])




                            $('#show_req_stats').val(e['data']['request_status']);
                            $('#show_approver').val(e['data']['get_approver_data'] ? e['data']['get_approver_data']['firstname']
                                + ' ' + e['data']['get_approver_data']['lastname'] : '');

                            $('#show_approve_date').val(e['data']['date_approved']);

                            show_req_stats
                            show_approver
                            show_approve_date

                            get_approver_data

                        }


                    }
                })
            }

            $('#tbl_transit').DataTable({
                ajax: {
                    url: "{{ route('get_shuttel_request_data') }}",

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
                        data: "action"
                    },
                ]
            });

            $('#add_request_btn').click(function () {
                $('#add_transit_room').modal('show');
            });

            $('#save_shuttle_btn').click(function () {
                const departure_date = $('#departure_date').val();
                const appointment_date = $('#appointment_date').val();
                const pickup_date = $('#pickup_date').val();
                const client_name = $('#client_name').val();
                const purpose = $('#purpose').val();
                const other_purpose = $('#other_purpose').val();
                const destination = $('#destination').val();
                const remarks = $('#remarks').val();
                const number_pass = $('#number_pass').val();
                const manager_app = $('#manager_app').val();
                const ob_form_file = $('#ob_form_file')[0].files[0];
                const add_shuttle_data = new FormData();

                if (ob_form_file == undefined) {
                    alertify.error('<span style="color: white;">OB form file is required</span>');
                    return;
                }

                add_shuttle_data.append('departure_date', departure_date);
                add_shuttle_data.append('appointment_date', appointment_date);
                add_shuttle_data.append('pick_up_date', pickup_date);
                add_shuttle_data.append('type', purpose);
                add_shuttle_data.append('purpose', other_purpose);
                add_shuttle_data.append('passenger_number', number_pass);
                add_shuttle_data.append('client_name', client_name);
                add_shuttle_data.append('manager_id', manager_app);
                add_shuttle_data.append('passenger_number', number_pass);
                add_shuttle_data.append('destination', destination);
                add_shuttle_data.append('remarks', remarks);
                add_shuttle_data.append('file[]', ob_form_file);



                $.ajax({
                    url: "{{ route('aits_save_shuttle_request') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: add_shuttle_data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {

                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }

                        $('#departure_date').val('');
                        $('#appointment_date').val('');
                        $('#pickup_date').val('');
                        $('#client_name').val('');
                        $('#purpose').val('');
                        $('#other_purpose').val('');
                        $('#destination').val('');
                        $('#remarks').val('');
                        $('#number_pass').val('');
                        $('#manager_app').val('');
                        $('#ob_form_file').val('');
                        $('#add_transit_room').modal('hide');
                        $('#tbl_transit').DataTable().ajax.reload();
                        Swal.fire('Success!', 'Your request has been successfully added.', 'success');

                    }
                })



            });





            $('#edit_type').change(function () {
                $('#edit_purpose').val('');

                if ($(this).val() === 'remarks') {
                    $('.edit_purpose_column_hidden').removeAttr('hidden');
                }
                else {
                    $('.edit_purpose_column_hidden').attr('hidden', true);
                }
            });



            $('#purpose').change(function () {
                $('#other_purpose').val('');

                if ($(this).val() === 'remarks') {
                    $('.purpose_column_hidden').removeAttr('hidden');
                }
                else {
                    $('.purpose_column_hidden').attr('hidden', true);
                }
            });

            $(document).on('click', '.btn_show_data', function () {
                retrieve_shuttle($(this).data('id'), 'show_data')

            });



            $(document).on('click', '.btn_edit', function () {
                retrieve_shuttle($(this).data('id'), 'edit_data')


            });

            $(document).on('click', '.btn_delete ', function () {


                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this request?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "delete_shuttle_request/" + $(this).data('id'),
                            success: function (e) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your request has been deleted.",
                                    icon: "success"
                                });

                                $('#tbl_transit').DataTable().ajax.reload();

                            }
                        })

                    }
                });


            });



            $('#edit_shuttle_btn').click(function () {

                const edit_id = $('#edit_id').val();
                const edit_departure_date = $('#edit_departure_date').val();
                const edit_appointment_date = $('#edit_appointment_date').val();
                const edit_pick_up_date = $('#edit_pick_up_date').val();
                const edit_type = $('#edit_type').val();
                const edit_purpose = $('#edit_purpose').val();
                const edit_destination = $('#edit_destination').val();
                const edit_remarks = $('#edit_remarks').val();
                const edit_client_name = $('#edit_client_name').val();
                const edit_passenger_number = $('#edit_passenger_number').val();
                const edit_manager_id = $('#edit_manager_id').val();
                const edit_ob_form = $('#edit_ob_form')[0].files[0];

                const edit_shuttle_data = new FormData();



                edit_shuttle_data.append('departure_date', edit_departure_date);
                edit_shuttle_data.append('appointment_date', edit_appointment_date);
                edit_shuttle_data.append('id', edit_id);
                edit_shuttle_data.append('pick_up_date', edit_pick_up_date);
                edit_shuttle_data.append('type', edit_type);
                edit_shuttle_data.append('purpose', edit_purpose);
                edit_shuttle_data.append('destination', edit_destination);
                edit_shuttle_data.append('remarks', edit_remarks);
                edit_shuttle_data.append('client_name', edit_client_name);
                edit_shuttle_data.append('passenger_number', edit_passenger_number);
                edit_shuttle_data.append('manager_id', edit_manager_id);

                // Append the file if it exists
                if (edit_ob_form) {
                    edit_shuttle_data.append('ob_form[]', edit_ob_form, edit_ob_form.name);
                }







                $.ajax({
                    url: "{{route('update_shuttle_request') }}",
                    processData: false,
                    contentType: false,
                    data: edit_shuttle_data,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {

                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }

                        $('#edit_shuttle_modal').modal('hide');
                        Swal.fire('Success!', 'Your request has been successfully Updated.', 'success');
                        $('#tbl_transit').DataTable().ajax.reload();



                    }
                })

            });




        });
    </script>

@endsection