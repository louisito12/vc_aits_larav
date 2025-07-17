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

        <div class="d-flex my-xl-auto right-content align-items-center">


            <div class="mb-xl-0">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="filter_btn" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Filter Request
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                        <li><a class="dropdown-item filter_data" value="1" href="javascript:void(0);">All</a></li>
                        <li><a class="dropdown-item filter_data" value="2" href="javascript:void(0);">All Pending</a>
                        </li>
                        <li><a class="dropdown-item filter_data" value="3" href="javascript:void(0);">All Approved</a>
                        </li>
                        <li><a class="dropdown-item filter_data" value="4" href="javascript:void(0);">All
                                Disapproved</a>
                        <li><a class="dropdown-item filter_data" value="4" href="javascript:void(0);">All Cancelled</a>

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
                    <div class="card-title m-1 p-3">Room Request</div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="room_request_tbl" class="table table-bordered text-nowrap w-100 table-sm">
                            <thead>
                                <tr>
                                    <th class="spec_input w-25">Request #</th>
                                    <th class="spec_input w-25">Request Room</th>
                                    <th class="spec_input w-25">Department</th>
                                    <th class="spec_input w-25">Date From</th>
                                    <th class="spec_input w-25">Date To</th>
                                    <th class="spec_input w-25">Event/Purpose</th>
                                    <th class="spec_input w-25">Date Requested</th>
                                    <th class="spec_input w-25">Request Status</th>
                                    <th class="spec_input w-25">Action</th>
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

    <div class="modal fade" id="view_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Room Request View
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Date From</label>
                            <input disabled id="view_date_from" type="datetime-local" class="form-control spec_input">
                        </div>

                        <div class="col-6">
                            <label>Date To</label>
                            <input disabled id="view_date_to" type="datetime-local" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Room Name</label>
                            <Select disabled id="view_room_name" class="form-control spec_input">
                                <option value="">Select Room</option>
                                @foreach ($room as $rooms)
                                    <option value="{{ $rooms->id }}">{{ $rooms->room_name }}</option>
                                @endforeach

                            </Select>
                        </div>
                        <div class="col-6">
                            <label>Events/Purpose</label>
                            <select disabled id="view_events" class="form-control  spec_input">
                                <option value="">Select Event</option>
                                @foreach ($event as $events)
                                    <option value="{{ $events->id }}">{{ $events->event }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="" class="row">
                        <div class="col-12">
                            <label>Purpose</label>
                            <textarea disabled id="view_purpose" class="form-control" id=""></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Requestor Name</label>
                            <input disabled type="text" id="show_requestor" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Request Status</label>
                            <input disabled type="text" id="show_data_status" class="form-control">
                        </div>
                        <div class="col-4">
                            <label>Approved By </label>
                            <input disabled type="text" id="show_data_approver" class="form-control">
                        </div>
                        <div class="col-4">
                            <label>Approved Date </label>
                            <input disabled type="text" id="show_data_approve_date" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row act_remarks">
                        <div class="col-12">
                            <label>Action Remarks</label>
                            <textarea disabled id="show_data_remarks" class="form-control"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>




    <!-- add user -->
    {{-- <div class="modal fade" id="view_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Room Request View
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Date From</label>
                            <input disabled id="view_date_from" type="datetime-local" class="form-control spec_input">
                        </div>
                        <div class="col-6">
                            <label>Date To</label>
                            <input disabled id="view_date_to" type="datetime-local" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Room Name</label>
                            <Select disabled id="view_room_name" class="form-control spec_input">
                                <option value="">Select Room</option>
                                @foreach ($room as $rooms)
                                    <option value="{{ $rooms->id }}">{{ $rooms->room_name }}</option>
                                @endforeach

                            </Select>
                        </div>
                        <div class="col-6">
                            <label>Events/Purpose</label>
                            <select disabled id="view_events" class="form-control  spec_input">
                                <option value="">Select Event</option>
                                @foreach ($event as $events)
                                    <option value="{{ $events->id }}">{{ $events->event }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="" class="row">
                        <div class="col-12">
                            <label>Purpose</label>
                            <textarea disabled id="view_purpose" class="form-control" id=""></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Requestor Name</label>
                            <input disabled type="text" id="show_requestor" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Status</label>
                            <input disabled id="status" type="text" class="form-control spec_input">
                        </div>

                        <div class="col-4">
                            <label>Approved By</label>
                            <input disabled id="approve_by" type="text" class="form-control spec_input">
                        </div>
                        <div class="col-4">
                            <label>Approved Date</label>
                            <input disabled id="approve_data_text" type="text" class="form-control spec_input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            function get_column() {
                return [{
                        data: 'request_no'
                    },
                    {
                        data: 'room'
                    },
                    {
                        data: 'department'
                    },
                    {
                        data: 'date_from'
                    },
                    {
                        data: 'date_to'
                    },
                    {
                        data: 'event'
                    },
                    {
                        data: 'date_created'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'admin_action'
                    }
                ];
            }

            $('#room_request_tbl').DataTable({
                destroy: true,
                ajax: {
                    url: "{{ route('get_room_approval_data') }}",
                    type: "POST",
                    data: {
                        pending_all: 1,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },


                },
                columns: get_column()
            });





            // $(document).on('click', '.btn_show_data', function() {

            //     $.ajax({
            //         url: "retrieve_room_request/" + $(this).data('id'),
            //         type: "GET",
            //         success: function(e) {
            //             if (e['isValid'] == false) {
            //                 alertify.error(e['msg']);
            //                 return;
            //             }
            //             $('#approve_by').val('');
            //             $('#approve_data_text').val('');
            //             $('#view_request_modal').modal('show');
            //             $('#view_date_from').val(e['data']['date_from']);
            //             $('#view_date_to').val(e['data']['date_to']);
            //             $('#view_room_name').val(e['data']['room_id']);
            //             $('#view_events').val(e['data']['event_id']);
            //             $('#view_purpose').val(e['data']['remarks']);
            //             $('#status').val(e['data']['request_status']);
            //             if (e['data']['get_approved_data']) {
            //                 $('#approve_by').val(e['data']['get_approved_data']['firstname'] +
            //                     ' ' + e['data']['get_approved_data']['lastname']);
            //                 $('#approve_data_text').val(e['data']['approve_date']);

            //             }

            //             $('#show_requestor').val(e['data']['get_requestor_data']['firstname'] +
            //                 ' ' + e['data']['get_requestor_data']['lastname']);



            //         }
            //     });


            $(document).on('click', '.btn_show_data', function() {
                $('.act_remarks').attr('hidden', true);

                $.ajax({
                    url: "retrieve_room_request/" + $(this).data('id'),
                    type: "GET",
                    success: function(e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] +
                                '</span>');
                            return;
                        }
                        $('#view_request_modal').modal('show');
                        $('#view_date_from').val(e['data']['date_from']);
                        $('#view_date_to').val(e['data']['date_to']);
                        $('#view_room_name').val(e['data']['room_id']);
                        $('#view_events').val(e['data']['event_id']);
                        $('#view_purpose').val(e['data']['remarks']);
                        if (e['data']['request_status'] != 'Cancelled') {
                            $('#show_data_approver').val(
                                e['data']['get_approved_data'] ?
                                e['data']['get_approved_data']['firstname'] + ' ' + e[
                                    'data'][
                                    'get_approved_data'
                                ]['lastname'] :
                                ''
                            );
                            $('#show_data_approve_date').val(e['data']['approve_date']);
                        }
                        $('#show_data_status').val(e['data']['status'] == 0 ? "Cancelled" : e[
                            'data']['request_status']);
                        $('#show_requestor').val(e['data']['get_requestor_data']['firstname'] +
                            ' ' + e['data']['get_requestor_data']['lastname']);


                        if (e['data']['get_remarks']) {
                            $('.act_remarks').removeAttr('hidden');

                            $('#show_data_remarks').val(e['data']['get_remarks']['remarks']);
                        }

                    }
                });
            });





            // $(document).on('click', '.btn_approved', function () {
            //     if ($(this).data('val') == 1) {
            //         var approve = 'Approved';
            //     }
            //     else {
            //         var approve = 'Disapprove';

            //     }




            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: 'Do you want to ' + approve + ' this request?',
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, approve it!',
            //         cancelButtonText: 'No, cancel'
            //     }).then((result) => {
            //         if (result.isConfirmed) {


            //             $.ajax({
            //                 url: "approved_room_request/" + $(this).data('id') + '/' + $(this).data('val'),
            //                 success: function (e) {
            //                     if (e['isValid'] == false) {
            //                         alertify.error(e['msg']);
            //                         return;
            //                     }
            //                     Swal.fire('Success!', 'The request has been Process.', 'success');
            //                     $('#room_request_tbl').DataTable().ajax.reload();
            //                 }

            //             })

            //         } else {

            //         }
            //     });
            // })


            $(document).on('click', '.btn_approved', function() {
                if ($(this).data('val') == 1) {
                    var approve = 'Approve';
                } else {
                    var approve = 'Disapprove';
                }
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to " + approve + " this request?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes," + approve + " it!",
                    input: 'textarea',
                    inputPlaceholder: 'Remarks of ' + approve,
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
                                    url: "approved_room_request/" + $(this)
                                        .data('id') + "/" + $(this).data(
                                            'val') + '/' + remarks,
                                    success: function(e) {
                                        if (e['isValid'] == false) {
                                            Swal.fire({
                                                icon: 'error',
                                                html: '<span style="color: white;">' +
                                                    e['msg'] +
                                                    '</span>',
                                                background: '#f27474',
                                                timer: 5000,
                                                showConfirmButton: false,
                                                timerProgressBar: true,
                                                toast: false,
                                            })
                                            reject('Deletion failed');
                                        } else {
                                            Swal.fire({
                                                title: approve +
                                                    '!',
                                                text: "Your request has been " +
                                                    approve,
                                                icon: "success"
                                            });
                                            $('#room_request_tbl')
                                                .DataTable().ajax.reload();
                                            resolve();
                                        }

                                    },

                                });
                            }
                        });
                    }
                })
            });






            $('.filter_data').on('click', function() {
                var filterValue = $(this).text().toLowerCase();
                $('#filter_btn').text($(this).text());
            })


            $('#filter_request').click(function() {
                const filter_params = $('#filter_btn').text().toLowerCase();
                const filter_array = ['all', 'all pending', 'all approved', 'all disapproved',
                    'all cancelled'
                ];

                if (!filter_array.includes(filter_params)) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.set('notifier', 'delay', 5);
                    alertify.error('<span style="color: white;">Please select filter</span>');
                    return;
                }

                $('#room_request_tbl').DataTable({
                    destroy: true,
                    ajax: {
                        url: "{{ route('get_room_approval_data') }}",
                        type: "POST",
                        data: {
                            filter_data: filter_params
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: get_column()
                });

                $('#filter_btn').text('Filter Request');


            });

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
                    inputPlaceholder: 'Reason for cancellation?',
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
                                    url: "delete_request/" + $(this).data(
                                        'id') + '/' + remarks,
                                    success: function(e) {
                                        if (e['isValid'] == false) {
                                            alertify.error(
                                                '<span style="color: white;">' +
                                                e['msg'] + '</span>');
                                            reject('Deletion failed');
                                        }

                                        Swal.fire({
                                            title: "Cancel!",
                                            text: "Your request has been Cancel.",
                                            icon: "success"
                                        });
                                        $('#room_request_tbl').DataTable()
                                            .ajax.reload();
                                        resolve();

                                    },

                                });
                            }
                        });
                    }
                })
            });


        });
    </script>
@endsection
