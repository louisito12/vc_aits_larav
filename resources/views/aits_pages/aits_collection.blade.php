@extends('aits_main_page')



@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Request for Collection</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Logistics Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Request for Collection</li>
                </ol>
            </nav>
        </div>



    </div>





    <!-- Page Header Close -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Collection Request</div>
                    <button id="add_request_btn" class="btn btn-success m-3">Add Request</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="deliver_tbl" class="table table-bordered text-nowrap w-100 table-sm text-center">
                            <thead>
                                <tr>

                                    <th class="text-center">Request #</th>
                                    <th class="text-center">Date Requested</th>
                                    <th class="text-center">Department </th>
                                    <th class="text-center">Collection Address</th>
                                    <th class="text-center">Area </th>
                                    <th class="text-center">Client Name </th>
                                    <th class="text-center">Company Name </th>
                                    <th class="text-center">View Request File </th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action </th>


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

    <div class="modal fade" id="add_delivery_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Collection Request Form
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label>Receiver Name</label>
                            <input type="text" id="name_receiver" class="form-control spec_input">
                        </div>
                        <div class="col-4">
                            <label>Company Name</label>
                            <input type="text" id="company_name" class="form-control spec_input">
                        </div>
                        <div class="col-4">
                            <label>Receiver Contact</label>
                            <input type="text" id="contact_receiver" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Collection Type</label>
                            <select id="delivery_type_id" class="form-control spec_input">
                                <option value="">Select Collection Type</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->del_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Area</label>
                            <select name="" id="area_id" class="form-control spec_input">
                                <option value="">Select Area</option>
                                @foreach ($area as $areas)
                                    <option value="{{ $areas->id }}">{{ $areas->area }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-4">
                            <label>Collection Counts</label>
                            <input type="number" id="count_documents" min="1" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Complete Address</label>

                            <textarea class="form-control spec_input" id="complete_address"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control spec_input" id="delivery_remarks"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Attachments</label>
                            <input type="file" name="" class="form-control" id="del_file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn_delivery" class="btn btn-primary">Add Request</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_delivery_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="edit_header"> Edit Collection Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label>Receiver Name</label>
                            <input type="text" id="edit_name_receiver" class="form-control spec_input">
                            <input type="text" hidden id="edit_id" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Company Name</label>
                            <input type="text" id="edit_company_name" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Receiver Contact</label>
                            <input type="text" id="edit_contact_receiver" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Collection Type</label>
                            <select id="edit_delivery_type_id" class="form-control spec_input">
                                <option value="">Select Collection Type</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->del_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Area</label>
                            <select name="" id="edit_area_id" class="form-control spec_input">
                                <option value="">Select Area</option>
                                @foreach ($area as $areas)
                                    <option value="{{ $areas->id }}">{{ $areas->area }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-4">
                            <label>Collection Counts</label>
                            <input type="number" id="edit_count_documents" min="1"
                                class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Complete Address</label>

                            <textarea class="form-control spec_input" id="edit_complete_address"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control spec_input" id="edit_delivery_remarks"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Attachments</label>
                            <input type="file" name="" class="form-control" id="edit_file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_delivery" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show_delivery_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="edit_header"> Show Collection Request
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
                            <label>Collection Type</label>
                            <select disabled id="show_delivery_type_id" class="form-control spec_input">
                                <option value="">Select Collection Type</option>
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
                            <label>Collection Counts</label>
                            <input disabled type="number" id="show_count_documents" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Complete Address</label>

                            <textarea disabled class="form-control spec_input" id="show_complete_address"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
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
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            // $('.get_value').change(function () {
            //     const array_id = [];
            //     $('.get_value:checked').each(function () {
            //         array_id.push($(this).val());
            //     });
            //     console.log(array_id);
            //     if ($(this).prop('checked')) {
            //         $('.get_value').prop('checked', true);
            //     }
            //     else {
            //         $('.get_value').prop('checked', false);
            //     }
            // });


            $('#deliver_tbl').DataTable({
                ajax: {
                    url: "show_delivery_request/2"
                },
                columns: [{
                        data: "request_no"
                    },

                    {
                        data: "date_created"
                    },
                    {
                        data: "department"
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
                        data: "view_file_request",
                    },
                    {
                        data: "req_status",
                    },

                    {
                        data: "action"
                    },
                ]
            });

            $('#add_request_btn').click(function() {
                $('#add_delivery_request_modal').modal('show');
            });

            $('#btn_delivery').click(function() {
                const name_receiver = $('#name_receiver').val();
                const company_name = $('#company_name').val();
                const contact_receiver = $('#contact_receiver').val();
                const delivery_type_id = $('#delivery_type_id').val();
                const area_id = $('#area_id').val();
                const count_documents = $('#count_documents').val();
                const complete_address = $('#complete_address').val();
                const delivery_remarks = $('#delivery_remarks').val();
                const file = $('#del_file')[0].files[0];
                if (name_receiver == "" || company_name == "" || contact_receiver == "" ||
                    delivery_type_id == "" || area_id == "" || count_documents == "" ||
                    complete_address == "" || delivery_remarks == "" || file == undefined || file == "") {
                    alertify.error('<span style="color: white;">All fields Required !</span>');
                    return;
                }

                const form_data = new FormData();
                form_data.append('name_receiver', name_receiver);
                form_data.append('company_name', company_name);
                form_data.append('contact_receiver', contact_receiver);
                form_data.append('delivery_type_id', delivery_type_id);
                form_data.append('area_id', area_id);
                form_data.append('count_documents', count_documents);
                form_data.append('complete_address', complete_address);
                form_data.append('delivery_remarks', delivery_remarks);
                form_data.append('file[]', file);
                form_data.append('procedures', 2);
                $.ajax({
                    url: "{{ route('aits_save_delivery') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: form_data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {},
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.set('notifier', 'delay', 5);
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return;
                        }
                        $('#add_delivery_request_modal').modal('hide');
                        $('#name_receiver').val('');
                        $('#company_name').val('');
                        $('#contact_receiver').val('');
                        $('#delivery_type_id').val('');
                        $('#area_id').val('');
                        $('#count_documents').val('');
                        $('#complete_address').val('');
                        $('#delivery_remarks').val('');
                        $('#del_file').val('');
                        $('#deliver_tbl').DataTable().ajax.reload();
                        Swal.fire('Success!', 'Your request has been successfully added.',
                            'success');
                    }
                })
            });

            $(document).on('click', '.btn_edit', function() {
                $('#edit_delivery_request_modal').modal('show');

                $.ajax({
                    url: "get_delivery_data/" + $(this).data('id'),
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return;
                        }

                        $('#edit_id').val(e['data']['id']);
                        $('#edit_name_receiver').val(e['data']['name_receiver']);
                        $('#edit_company_name').val(e['data']['company_name']);
                        $('#edit_contact_receiver').val(e['data']['contact_receiver']);
                        $('#edit_delivery_type_id').val(e['data']['delivery_type_id']);
                        $('#edit_area_id').val(e['data']['area_id']);
                        $('#edit_count_documents').val(e['data']['count_documents']);
                        $('#edit_complete_address').val(e['data']['complete_address']);
                        $('#edit_delivery_remarks').val(e['data']['delivery_remarks']);




                    }
                });
            });


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
                        return '	Picked Up';
                    }
                }


            }


            $(document).on('click', '.btn_show_data', function() {
                $('#show_delivery_request_modal').modal('show');
                $('#messenger_file').html('');

                $('#row_messenger').addClass('d-none');
                $('#row_messenger_reschedule').addClass('d-none');



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



                        // if (e['data']['get_admin_data']) {
                        //     //if admin has assign messenger
                        //     $('.row_admin').removeAttr('hidden')
                        //     $('#admin_name').val(e['data']['get_admin_data']['firstname'] + ' ' + e['data']['get_admin_data']['lastname'])
                        //     $('#delivery_date').val(e['data']['procedure_date'])
                        //     $('#messenger_name').val(e['data']['get_messenger_name']['firstname'] + ' ' + e['data']['get_messenger_name']['lastname'])

                        // }

                        // if (e['data']['messenger_file'] == 'nofile') {
                        //     return;
                        // }

                        // $('#row_messenger').removeClass('d-none');
                        // $('#messenger_file').html('<a href="' + e['data']['messenger_file'] + '" target="_blank">' + e['data']['file_name'] + '</a>');
                        // $('#mess_remarks').val(e['data']['messenger_remarks']);

                        const stats_name = status_namer(e['data']['status'], e['data'][
                            'procedures'
                        ], e['data']['request_status']);
                        $('#stat_logs').val(stats_name);



                        if (e['data']['request_status'] == 'Delivered') {
                            $('#row_messenger').removeClass('d-none');
                            $('#messenger_file').html('<a href="' + e['data'][
                                'messenger_file'
                            ] + '" target="_blank">' + e['data'][
                                'file_name'
                            ] + '</a>');
                            $('#mess_remarks').val(e['data']['messenger_remarks']);
                        }

                        if (e['data']['request_status'] == 'Reschedule') {
                            $('#row_messenger_reschedule').removeClass('d-none');
                            $('#reschedule_remarks').val(e['data']['messenger_remarks'] || '');
                            $('#date_rescheduled').val(e['data']['procedure_date'] || '');
                        }


                        if (e['data']['request_status'] == 'Cancelled') {
                            $('#stat_logs').val('Cancelled');
                        }



                    }
                })
            })

            // $(document).on('click', '.btn_delete', function () {
            //     Swal.fire({
            //         title: "Are you sure?",
            //         text: "You want to delete this request ?",
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: "#3085d6",
            //         cancelButtonColor: "#d33",
            //         confirmButtonText: "Yes, delete it!"
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 url: "delete_delivery_request/" + $(this).data('id'),
            //                 success: function (e) {
            //                     $('#deliver_tbl').DataTable().ajax.reload();
            //                     Swal.fire({
            //                         title: "Deleted!",
            //                         text: "Your request has been deleted.",
            //                         icon: "success"
            //                     });
            //                 }
            //             })


            //         }
            //     });


            // })


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
                                        $('#deliver_tbl').DataTable().ajax
                                            .reload();
                                        resolve();

                                    },

                                });
                            }
                        });
                    }
                })
            });


            $('#edit_delivery').click(function() {

                const edit_id = $('#edit_id').val();
                const edit_name_receiver = $('#edit_name_receiver').val();
                const edit_company_name = $('#edit_company_name').val();
                const edit_contact_receiver = $('#edit_contact_receiver').val();
                const edit_delivery_type_id = $('#edit_delivery_type_id').val();
                const edit_area_id = $('#edit_area_id').val();
                const edit_count_documents = $('#edit_count_documents').val();
                const edit_complete_address = $('#edit_complete_address').val();
                const edit_delivery_remarks = $('#edit_delivery_remarks').val();
                const edit_file = $('#edit_file')[0].files[0];


                const edit_form_data = new FormData();
                edit_form_data.append('name_receiver', edit_name_receiver);
                edit_form_data.append('company_name', edit_company_name);
                edit_form_data.append('contact_receiver', edit_contact_receiver);
                edit_form_data.append('delivery_type_id', edit_delivery_type_id);
                edit_form_data.append('area_id', edit_area_id);
                edit_form_data.append('count_documents', edit_count_documents);
                edit_form_data.append('complete_address', edit_complete_address);
                edit_form_data.append('delivery_remarks', edit_delivery_remarks);
                edit_form_data.append('id', edit_id);
                edit_form_data.append('procedures', 2);


                if (edit_file != undefined) {
                    edit_form_data.append('file[]', edit_file);
                }


                $.ajax({
                    url: "{{ route('edit_delivery_request') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: edit_form_data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {},
                    success: function(e) {

                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return;
                        }

                        $('#edit_delivery_request_modal').modal('hide');
                        Swal.fire('Success!', 'Your request has been successfully updated.',
                            'success');
                        $('#deliver_tbl').DataTable().ajax.reload();


                    }

                })




            });

        });

































        // $('.get_value').change(function () {
        //     const array_id = [];
        //     $('.get_value:checked').each(function () {
        //         array_id.push($(this).val());
        //     });
        //     console.log(array_id)
        // });
        // $('.get_value').on('change', function () {
        //     const selectedValues = [];

        //     $('.get_value').each(function () {
        //         if ($(this).prop('checked')) {
        //             selectedValues.push($(this).val());
        //         }
        //     });

        //     console.log(selectedValues);
        // });

        // $('.get_value').on('change', function () {
        //     const selectedValues = [];
        //     const checkboxes = $('.get_value');

        //     for (let i = 0; i < checkboxes.length; i++) {
        //         const checkbox = checkboxes[i];
        //         if ($(checkbox).prop('checked')) {
        //             selectedValues.push($(checkbox).val());
        //         }
        //     }

        //     console.log(selectedValues);
        // });
    </script>
@endsection
