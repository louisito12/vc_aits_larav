@extends('aits_main_page')



@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">My Logisitics</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Logisitics</li>
                </ol>
            </nav>
        </div>
        <!-- <div   class="d-flex my-xl-auto right-content align-items-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="pe-1 mb-xl-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="mdi mdi-filter-variant"></i></button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="pe-1 mb-xl-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button type="button" class="btn btn-danger btn-icon me-2"><i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="mdi mdi-star"></i></button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="pe-1 mb-xl-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button type="button" class="btn btn-warning  btn-icon me-2"><i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="mdi mdi-refresh"></i></button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div  class="mb-xl-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="dropdown">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuDate"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                14 Aug 2019
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a class="dropdown-item" href="javascript:void(0);">2015</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a class="dropdown-item" href="javascript:void(0);">2016</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a class="dropdown-item" href="javascript:void(0);">2017</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li><a class="dropdown-item" href="javascript:void(0);">2018</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->

    </div>

    <!-- Page Header Close -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">
                        Information
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="messenger_tbl" class="table table-bordered text-nowrap w-100 table-sm text-center">
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
                                    <th class="text-center">Procedure Date </th>
                                    <th class="text-center">View Request File </th>
                                    <th class="text-center">Status</th>
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



    <!-- Modals -->

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
                            <label>Assign By</label>
                            <input type="text" disabled class="form-control spec_input" id="admin_name">
                        </div>
                        <div class="col-4">
                            <label>Assign By</label>
                            <input type="text" disabled class="form-control spec_input" id="date_assign">
                        </div>
                        <input type="text" hidden id="process_val">
                        <input type="text" hidden id="hidden_id">

                    </div>
                    <br>

                    <div id="row_delivery" class="row row_hidden">
                        <div class="col-6">
                            <label>Messenger Remarks</label>
                            <textarea class="form-control spec_input" name="" id="messenger_remarks"></textarea>
                        </div>
                        <div class="col-6">
                            <label>File Proof</label>
                            <input type="file" name="" class="form-control spec_input" id="file">
                        </div>
                    </div>
                    <div id="row_resched" class="row row_hidden">
                        <div class="col-6">
                            <label>Messenger Remarks</label>
                            <textarea class="form-control spec_input" name="" id="reschedule_remarks"></textarea>
                        </div>

                        <div class="col-6">
                            <label>Date Reschedule</label>
                            <input type="datetime-local" class="form-control spec_input" id="date_resched">
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn_messenger" class="btn btn-primary">Close</button>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#messenger_tbl').DataTable({
                // scrollX: true,
                ajax: {
                    url: "{{ route('aits_messenger_logistics') }}",
                    serverSide: true,
                },
                columns: [{
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
                        render: function(data, type, row) {
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
                        data: "mess_schedule"
                    },
                    {
                        data: "view_file_request"
                    },

                    {
                        data: "req_status"
                    },
                    {
                        data: "action"
                    },
                ],


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
            });

            $(document).on('click', '.btn_deliver', function() {
                //delivery process
                $('.row_hidden').attr('hidden', true);

                const delivery_id = $(this).data('id')
                const delivery_val = $(this).data('val');
                $('#process_val').val(delivery_val);

                $.ajax({
                    url: "get_delivery_data/" + $(this).data('id'),
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
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
                        $('#edit_header').text(e['data']['req_stat'] + ' Request #' + e['data'][
                            'request_number'
                        ]);
                        $('#admin_name').val(
                            e['data']['get_admin_data'] ?
                            e['data']['get_admin_data']['firstname'] + ' ' + e['data'][
                                'get_admin_data'
                            ]['lastname'] :
                            '');
                        $('#date_assign').val(e['data']['date_assign']);
                        $('#hidden_id').val(e['data']['id'])


                    }
                })


                if (delivery_val == 1) {
                    $('#btn_messenger').text('Delivered Request')
                    //for delivery
                    $('#show_delivery_request_modal').modal('show');
                    $('#row_delivery').removeAttr('hidden')


                }

                if (delivery_val == 2) {
                    $('#show_delivery_request_modal').modal('show');
                    $('#row_resched').removeAttr('hidden')
                    $('#btn_messenger').text('Reschedule Request')

                }



            });


            $('#btn_messenger').click(function() {
                const messenger_process_val = $('#process_val').val();
                const request_id = $('#hidden_id').val();
                const messenger_remarks = $('#messenger_remarks').val();
                const messenger_file = $('#file')[0].files[0];
                const date_resched = $('#date_resched').val();
                const reschedule_remarks = $('#reschedule_remarks').val();


                if (messenger_process_val == 1) {
                    //if for delivered
                    if (messenger_file == undefined || messenger_file == "") {
                        alertify.error('<span style="color: white;">Proof File is Required</span>');
                        return;
                    }

                }


                const maxSize = 5 * 1024 * 1024; // 5MB in bytes

                if (messenger_file.size > maxSize) {
                    alertify.error('<span style="color: white;">OB form file must not exceed 5MB</span>');
                    return;
                }




                const messenger_delivered = new FormData();
                messenger_delivered.append('id', request_id);
                messenger_delivered.append('messenger_remarks', messenger_remarks);
                messenger_delivered.append('file[]', messenger_file);
                messenger_delivered.append('process_val', messenger_process_val);
                messenger_delivered.append('date_resched', date_resched);
                messenger_delivered.append('reschedule_remarks', reschedule_remarks);

                $.ajax({
                    url: "{{ route('messenger_delivered') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: messenger_delivered,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return;
                        }

                        $('#show_delivery_request_modal').modal('hide');
                        $('#messenger_tbl').DataTable().ajax.reload();

                        Swal.fire({
                            title: e['alert_msg'] + '!',
                            text: "Your request has been Delivered.",
                            icon: "success"
                        });

                        $('#messenger_remarks').val('');
                        $('#file').val('');
                        $('#date_resched').val("");
                        $('#reschedule_remarks').val("+");

                    }
                });


            })


            $(document).on('click', '.btn_delete', function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to cancel this request?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, cancel it!",
                    input: 'textarea',
                    inputPlaceholder: 'Reason for deletion?',
                    inputAttributes: {
                        'aria-label': 'Enter your remarks'
                    },
                    showLoaderOnConfirm: true,
                    preConfirm: (remarks) => {
                        return new Promise((resolve, reject) => {
                            if (!remarks || remarks.trim() === '') {
                                Swal.showValidationMessage('Remarks are required!');
                                reject('Remarks are required!');
                                Swal.hideLoading();
                            } else {
                                $.ajax({
                                    url: "delete_delivery_request/" + $(this)
                                        .data('id') + '/' + remarks,
                                    success: function(e) {
                                        if (e['isValid'] == false) {
                                            alertify.error(
                                                '<span style="color: white;">' +
                                                e['msg'] + '</span>');
                                            reject('Deletion failed');
                                        }

                                        Swal.fire({
                                            title: "Cancelled!",
                                            text: "Your request has been cancelled.",
                                            icon: "success"
                                        });
                                        $('#messenger_tbl').DataTable().ajax
                                            .reload();
                                        resolve();

                                    },

                                });
                            }
                        });
                    }
                })
            });
        })
    </script>
@endsection
