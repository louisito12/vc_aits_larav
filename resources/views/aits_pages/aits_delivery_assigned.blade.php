@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Request for Delivery</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Logistics Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Request for Delivery</li>
                </ol>
            </nav>
        </div>



        <div class="d-flex my-xl-auto right-content align-items-center">



            <div class="mb-xl-0">
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="log_btn" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Logistics Type
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                        <li><a class="dropdown-item log_types" value="2" href="javascript:void(0);">All</a></li>
                        <li><a class="dropdown-item log_types" value="2" href="javascript:void(0);">For Delivery</a></li>
                        <li><a class="dropdown-item log_types" value="3" href="javascript:void(0);">For Collection</a>
                        </li>
                        <li><a class="dropdown-item log_types" value="4" href="javascript:void(0);">For Pick Up</a>
                        </li>

                    </ul>
                </div>
            </div>
            &nbsp;


            <div class="mb-xl-0">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="filter_btn" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Filter Request
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                        <li><a class="dropdown-item filter_data" value="1" href="javascript:void(0);">All</a></li>
                        <li><a class="dropdown-item filter_data" value="2" href="javascript:void(0);">Pending</a></li>
                        <li><a class="dropdown-item filter_data" value="3" href="javascript:void(0);">Rescheduled</a></li>
                        <li><a class="dropdown-item filter_data" value="4" href="javascript:void(0);">Completed</a>
                        </li>

                    </ul>
                </div>
            </div>
            &nbsp;

            <div class="pe-1 mb-xl-0">
                <button id="filter_request" type="button" class="btn btn-success  btn-icon me-2"><i
                        class="fa-solid fa-magnifying-glass-location"></i></button>
            </div>
        </div>


    </div>



    <!-- Page Header Close -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3"> Logistic Information</div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="deliver_tbl" class="table table-bordered text-nowrap w-100 table-sm text-center ">
                            <thead>
                                <tr>
                                    <th class="text-center">Request #</th>
                                    <th class="text-center">Logistic</th>
                                    <th class="text-center">Date Requested</th>
                                    <th class="text-center">Department </th>
                                    <th class="text-center">Requestor </th>
                                    <th class="text-center">Delivery Address</th>
                                    <th class="text-center">Area </th>
                                    <th class="text-center">Client Name </th>
                                    <th class="text-center">Company Name </th>
                                    <th class="text-center">View Request File </th>
                                    <th class="text-center">Status</th>
                                    <!-- <th class="text-center">Assign status</th> -->
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

    <!-- Modal -->



    <!-- add user -->
    <div class="modal fade" id="assigne_mess_modal" tabindex="-1" aria-labelledby="assigneMessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- modal-dialog-centered -->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="assigneMessModalLabel">Assign Messenger</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- <div class="row mb-3"> -->
                    <div class="row">
                        <div class="col-4">
                            <label for="request_number" class="form-label">Request Number</label>
                            <input type="text" id="request_number" class="form-control" disabled>
                        </div>
                        <div class="col-4">
                            <label for="request_status" class="form-label">Request Status</label>
                            <input type="text" id="request_status" class="form-control" disabled>
                        </div>
                        <div class="col-4">
                            <label for="date_requested" class="form-label">Date Requested</label>
                            <input type="text" id="date_requested" class="form-control" disabled>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">

                            <label class="form-label">Requestor Name</label>
                            <input type="text" id="requestor_name" class="form-control" disabled>
                            <input type="text" id="hidden_id" hidden class="form-control" disabled>


                        </div>
                        <div class="col-4">

                            <label class="form-label">Messenger Name</label>
                            <select class="form-control" id="messenger_id">
                                <option value="">Choose a Messenger</option>
                                @foreach ($messenger as $messengers)

                                    <option value="{{ $messengers->cen_user_id }}">{{ $messengers->fname }}
                                        {{ $messengers->lname }}
                                    </option>

                                @endforeach
                            </select>

                        </div>
                        <div class="col-4">

                            <label class="form-label">Prcoessing Date</label>

                            <input min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T00:00:00" class="form-control"
                                type="datetime-local" id="process_date">


                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control" id="assign_remarks"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="assign_messenger" class="btn btn-primary">Assign Messenger</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="show_delivery_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="edit_header"> Logistics Request Details
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label>Receiver Name</label>
                            <input disabled type="text" id="show_name_receiver" class="form-control spec_input">
                            <input type="text" hidden id="show_id" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Company Name</label>
                            <input disabled type="text" id="show_company_name" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Receiver Contact</label>
                            <input disabled type="text" id="show_contact_receiver" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Delivery Type</label>
                            <select disabled id="show_delivery_type_id" class="form-control spec_input">
                                <option value="">Select Delivery Type</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->del_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Area</label>
                            <select disabled name="" id="show_area_id" class="form-control spec_input">
                                <option value="">Select Area</option>
                                @foreach ($area as $areas)
                                    <option value="{{ $areas->id }}">{{ $areas->area }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-4">
                            <label>Document Counts</label>
                            <input disabled type="number" id="show_count_documents" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Complete Address</label>
                            <textarea disabled class="form-control spec_input" id="show_complete_address"></textarea>
                        </div>
                        <div class="col-6">
                            <label>Remarks</label>
                            <textarea disabled class="form-control spec_input" id="show_delivery_remarks"></textarea>
                        </div>
                    </div>
                    <br>



                    <div class="row">
                        <div class="col-4">
                            <label>Requestor</label>
                            <input type="text" disabled class="form-control spec_input" id="req_name">
                        </div>


                        <div class="col-4">
                            <label>Status</label>
                            <input type="text" disabled class="form-control spec_input" id="stat_logs">
                        </div>

                        <input type="text" hidden id="process_val">
                        <input type="text" hidden id="hidden_id">

                    </div>
                    <br>


                    <div id="row_messenger" class="row">
                        <div class="col-6">
                            <label>Delivery remarks</label>
                            <textarea class="form-control spec_input" disabled id="mess_remarks"></textarea>
                        </div>

                        <div class="col-6 file_column">
                            <label>Files</label>
                            <div id="messenger_file"></div>
                        </div>

                    </div>

                    <div id="row_messenger_reschedule" class="row">
                        <div class="col-4">
                            <label>Date Reschedule</label>
                            <input disabled class="form-control spec_input" id="date_rescheduled" type="text">
                        </div>

                        <div class="col-4">
                            <label>Delivery Remarks</label>
                            <input disabled class="form-control spec_input" id="reschedule_remarks" type="text">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- End modal -->


@endsection


@section('scripts')
    <script>
        $(document).ready(function () {

            function get_columns() {
                return [
                    {
                        data: "request_no"
                    },
                    {
                        data: "logistics_stat"
                    },

                    {
                        data: "date_created"
                    },
                    {
                        data: "department"
                    },
                    {
                        data: "requestor"
                    },
                    {
                        data: "complete_address"
                    },
                    {
                        data: 'get_area_request',
                        render: function (data, type, row) {
                            return row.get_area_request.area;
                        }
                    },
                    {
                        data: "name_receiver"
                    },
                    {
                        data: "company_name"
                    },
                    {
                        data: "view_file_request",
                    },
                    {
                        data: "req_status",
                    },
                    // {
                    //     data: "messenger_stat"
                    // },
                    {
                        data: "action",
                    },
                ];
            }


            function status_namer(status, procedure, proc_stat) {
                if (status == 0) {
                    return 'Cancelled';
                }

                if (procedure == 1) {
                    if (proc_stat == 'Pending') {
                        return 'Undelivered'
                    }
                    if (proc_stat == 'Reschedule') {
                        return 'Rescheduled';
                    }
                    if (proc_stat == 'Delivered') {
                        return 'Delivered';
                    }
                }

                if (procedure == 2) {
                    if (proc_stat == 'Pending') {
                        return 'Uncollected'
                    }
                    if (proc_stat == 'Reschedule') {
                        return 'Rescheduled';
                    }
                    if (proc_stat == 'Delivered') {
                        return 'Collected';
                    }
                }

                if (procedure == 3) {
                    if (proc_stat == 'Pending') {
                        return 'Unpicked'
                    }
                    if (proc_stat == 'Reschedule') {
                        return 'Rescheduled';
                    }
                    if (proc_stat == 'Delivered') {
                        return 'Picked Up';
                    }
                }


            }





            $('#deliver_tbl').DataTable({
                destroy: true,
                scrollX: true,
                // scrollY: 'calc(95vh / 2.5)',

                ajax: {
                    url: "{{ route('get_logistics_request') }}",
                    type: "POST",

                    data: {
                        pending_data: 1,
                    },

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: get_columns(),
            });





            $(document).on('click', '.btn_approved', function () {
                const params_val = $(this).data('val');
                if (params_val == 1) {
                    //assign messenger
                    $('#assigne_mess_modal').modal('show');
                    $.ajax({
                        url: "get_delivery_data/" + $(this).data('id'),
                        dataType: 'json',
                        success: function (e) {
                            if (e['isValid'] === false) {
                                alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                                return;
                            }
                            $('#date_requested').val(e['data']['date_requested']);
                            $('#request_number').val(e['data']['request_number']);
                            $('#request_status').val(e['data']['req_stat']);
                            $('#requestor_name').val(e['data']['get_requestor_fullname']['firstname'] + ' ' + e['data']['get_requestor_fullname']['lastname'])
                            $('#hidden_id').val(e['data']['id']);

                        },

                    });


                }

            });

            $('#assign_messenger').click(function () {
                const logistics_id = $('#hidden_id').val();
                const messenger_id = $('#messenger_id').val();
                const process_date = $('#process_date').val();
                const assign_remarks = $('#assign_remarks').val();

                $.ajax({
                    url: "{{ route('assigned_messenger') }}",
                    type: "POST",
                    data: {
                        id: logistics_id,
                        messenger_id: messenger_id,
                        procedure_date: process_date,
                        assign_remarks: assign_remarks,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#messenger_id').val('');
                        $('#process_date').val('');
                        $('#assigne_mess_modal').modal('hide');
                        $('#deliver_tbl').DataTable().ajax.reload();
                        Swal.fire('Success!', 'The request has been Process.', 'success');
                        $('#assign_remarks').val('');
                    }
                })




            });







            $(document).on('click', '.btn_show_data', function () {
                //delivery process




                $('#messenger_file').html('');
                $('#row_messenger').addClass('d-none');
                $('#row_messenger_reschedule').addClass('d-none');

                $('#show_delivery_request_modal').modal('show');
                $.ajax({
                    url: "get_delivery_data/" + $(this).data('id'),
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#show_id').val(e['data']['id']);
                        $('#show_name_receiver').val(e['data']['name_receiver']);
                        $('#show_company_name').val(e['data']['company_name']);
                        $('#show_contact_receiver').val(e['data']['contact_receiver']);
                        $('#show_delivery_type_id').val(e['data']['delivery_type_id']);
                        $('#show_area_id').val(e['data']['area_id']);
                        $('#show_count_documents').val(e['data']['count_documents']);
                        $('#show_complete_address').val(e['data']['complete_address']);
                        $('#show_delivery_remarks').val(e['data']['delivery_remarks']);
                        $('#req_name').val(e['data']['get_requestor_fullname']['firstname'] +
                            ' ' + e['data']['get_requestor_fullname']['lastname'])
                        $('#edit_header').text(e['data']['req_stat'] + ' Request #' + e['data']['request_number']);
                        // $('#admin_name').val(
                        //     e['data']['get_admin_data']
                        //         ? e['data']['get_admin_data']['firstname'] + ' ' + e['data']['get_admin_data']['lastname']
                        //         : '');
                        // $('#date_assign').val(e['data']['date_assign']);
                        $('#hidden_id').val(e['data']['id'])

                        const stats_name = status_namer(e['data']['status'], e['data']['procedures'], e['data']['request_status']);
                        $('#stat_logs').val(stats_name);



                        if (e['data']['request_status'] == 'Delivered') {
                            $('#row_messenger').removeClass('d-none');
                            $('#messenger_file').html('<a href="' + e['data']['messenger_file'] + '" target="_blank">' + e['data']['file_name'] + '</a>');
                            $('#mess_remarks').val(e['data']['messenger_remarks']);
                        }

                        if (e['data']['request_status'] == 'Reschedule') {
                            $('#row_messenger_reschedule').removeClass('d-none');
                            $('#reschedule_remarks').val(e['data']['messenger_remarks'] || '');
                            $('#date_rescheduled').val(e['data']['procedure_date'] || '');
                        }






                    }
                })

            });


            $('.filter_data').on('click', function () {
                var filterValue = $(this).text().toLowerCase();
                $('#filter_btn').text($(this).text());
            })

            $('.log_types').on('click', function () {
                var log_value = $(this).text().toLowerCase();
                $('#log_btn').text($(this).text());
            })



            $('#filter_request').click(function () {
                const filt_params = $('#filter_btn').text().trim().toLowerCase();
                const logs_params = $('#log_btn').text().trim().toLowerCase();
                const filter_array = ['all', 'pending', 'rescheduled', 'completed'];
                const logs_array = ['all', 'for delivery', 'for collection', 'for pick up'];
                if (!filter_array.includes(filt_params) || !logs_array.includes(logs_params)) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.set('notifier', 'delay', 5);
                    alertify.error('<span style="color: white;">Please select Logistics and Filter</span>');
                    return;
                }
                $('#deliver_tbl').DataTable({
                    destroy: true,
                    ajax: {
                        url: "{{ route('get_logistics_request') }}",
                        type: "POST",
                        data: {
                            // filter_data: filter_params
                            filt_params: filt_params,
                            logs_params: logs_params,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: get_columns()
                });

                $('#filter_btn').text('Filter Request');
                $('#log_btn').text('Logistics Type')

            });




        });

    </script>
@endsection