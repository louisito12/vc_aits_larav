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
                        <table id="room_request_tbl" class="table table-bordered text-nowrap table-sm text-center">
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




    <!-- Modal -->

    <!-- add user -->
    <div class="modal fade" id="add_room_request" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Room Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Date From</label>
                            <input id="date_from" type="datetime-local" class="form-control spec_input">
                        </div>

                        <div class="col-6">
                            <label>Date To</label>
                            <input id="date_to" type="datetime-local" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Room Name</label>
                            <Select id="room_val" class="form-control spec_input">
                                <option value="">Select Room</option>
                                @foreach ($room as $rooms)
                                    <option value="{{ $rooms->id }}">{{ $rooms->room_name }}</option>
                                @endforeach

                            </Select>
                        </div>
                        <div class="col-6">
                            <label>Events/Purpose</label>
                            <select id="event_val" class="form-control  spec_input">
                                <option value="">Select Event</option>
                                @foreach ($event as $events)
                                    <option value="{{ $events->id }}">{{ $events->event }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="purpose_row" hidden class="row">
                        <div class="col-12">
                            <label>Purpose</label>
                            <textarea class="form-control" id="purpose"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save_room_request" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="update_room_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Room Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Date From</label>
                            <input id="edit_update_from" type="datetime-local" class="form-control spec_input">
                            <input id="hidden_id" type="text" hidden class="form-control spec_input">

                        </div>

                        <div class="col-6">
                            <label>Date To</label>
                            <input id="edit_update_to" type="datetime-local" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Room Name</label>
                            <Select id="edit_room_id" class="form-control spec_input">
                                <option value="">Select Room</option>
                                @foreach ($room as $rooms)
                                    <option value="{{ $rooms->id }}">{{ $rooms->room_name }}</option>
                                @endforeach

                            </Select>
                        </div>
                        <div class="col-6">
                            <label>Events/Purpose</label>
                            <select id="edit_event" class="form-control  spec_input">
                                <option value="">Select Event</option>
                                @foreach ($event as $events)
                                    <option value="{{ $events->id }}">{{ $events->event }}</option>
                                @endforeach
                                <option value="remarks">Others</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="edit_purpose_row" class="row">
                        <div class="col-12">
                            <label>Purpose</label>
                            <textarea class="form-control" id="edit_purpose"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_room_request_btn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#add_request_btn').click(function () {
                $('#add_room_request').modal('show')
            })

            $('#save_room_request').click(function () {
                const room_id = $('#room_val').val();
                const event_id = $('#event_val').val();
                const date_to = $('#date_to').val();
                const date_from = $('#date_from').val();
                const purpose = $('#purpose').val();

                $.ajax({
                    url: "{{ route('aits_save_room_request') }}",
                    type: "POST",
                    data: {
                        room_id: room_id,
                        event_id: event_id,
                        date_to: date_to,
                        date_from: date_from,
                        remarks: purpose
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#add_room_request').modal('hide')
                        Swal.fire({
                            title: "Good job!",
                            text: "Successfully added request!",
                            icon: "success"
                        });
                        $('#room_request_tbl').DataTable().ajax.reload();
                        $('#room_val').val("");
                        $('#event_val').val("");
                        $('#date_to').val("");
                        $('#date_from').val("");
                        $('#purpose').val("");

                    }

                });


            });

            $('#event_val').change(function () {
                $('#purpose').val('');
                if ($(this).val() == "remarks") {
                    $('#purpose_row').removeAttr('hidden');
                }
                else {

                    $('#purpose_row').attr('hidden', true);
                }
            })

            $('#room_request_tbl').DataTable({
                ajax: {
                    url: "{{ route('get_request_data') }}",

                },
                columns: [
                    {
                        data: "request_no"
                    },
                    {
                        data: "room"
                    },

                    {
                        data: "department"
                    },
                    {
                        data: "date_from"
                    },
                    {
                        data: "date_to"
                    },
                    {
                        data: "event"
                    },
                    {
                        data: "date_created"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "action"
                    },


                ],
            });


            $(document).on('click', '.btn_show_data', function () {

                $.ajax({
                    url: "retrieve_room_request/" + $(this).data('id'),
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#view_request_modal').modal('show');
                        $('#view_date_from').val(e['data']['date_from']);
                        $('#view_date_to').val(e['data']['date_to']);
                        $('#view_room_name').val(e['data']['room_id']);
                        $('#view_events').val(e['data']['event_id']);
                        $('#view_purpose').val(e['data']['remarks']);





                    }
                });

            });

            $(document).on('click', '.btn_edit ', function () {
                $.ajax({
                    url: "retrieve_room_request/" + $(this).data('id'),
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }

                        $('#hidden_id').val(e['data']['id']);
                        $('#edit_update_from').val(e['data']['date_from'])
                        $('#edit_update_to').val(e['data']['date_to'])
                        $('#edit_room_id').val(e['data']['room_id'])
                        $('#edit_purpose').val(e['data']['remarks'])
                        $('#edit_event').val(e['data']['event_id'])
                        $('#update_room_request_modal').modal('show');

                    }
                });
            });


            $(document).on('click', '.btn_delete ', function () {


                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this request?!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "delete_request/" + $(this).data('id'),
                            success: function (e) {
                                if (e['isValid'] == false) {
                                    alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                                    return;
                                }
                                $('#room_request_tbl').DataTable().ajax.reload();

                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your Request has been deleted.",
                                    icon: "success"
                                });
                            }
                        })

                    }
                });

            })


            $('#edit_room_request_btn').click(function () {
                const edit_id = $('#hidden_id').val();
                const edit_date_from = $('#edit_update_from').val();
                const edit_date_to = $('#edit_update_to').val();
                const edit_room_id = $('#edit_room_id').val();
                const edit_edit_purpose = $('#edit_purpose').val()
                const edit_event = $('#edit_event').val();


                $.ajax({
                    url: "{{ route('update_request_room') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: edit_id,
                        date_from: edit_date_from,
                        date_to: edit_date_to,
                        room_id: edit_room_id,
                        event_id: edit_event,
                        remarks: edit_edit_purpose,
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#update_room_request_modal').modal('hide');

                        Swal.fire({
                            title: "Good job!",
                            text: "Successfully added request!",
                            icon: "success"
                        });
                        $('#room_request_tbl').DataTable().ajax.reload();

                    }
                })
            });

            $('#edit_event').change(function () {
                $('#edit_purpose').val('');
                if ($(this).val() == "remarks") {
                    $('#edit_purpose_row').removeAttr('hidden');
                }
                else {

                    $('#edit_purpose_row').attr('hidden', true);
                }
            })
        })
    </script>

@endsection