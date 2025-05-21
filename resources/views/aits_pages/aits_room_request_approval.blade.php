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


            <!-- <div hidden class="mb-xl-0">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuDate"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Filter Request
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                        <li><a class="dropdown-item test" href="javascript:void(0);">All</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Approval For Today</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">All Pending</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">All Approved</a></li>
                    </ul>
                </div>
            </div>
            &nbsp;

            <div class="pe-1 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon me-2"><i class="mdi mdi-refresh"></i></button>
            </div> -->
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
                        <table id="room_request_tbl" class="table table-bordered text-nowrap table-sm">
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

    <!-- add user -->


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
    </div>






@endsection


@section('scripts')

    <script>
        $(document).ready(function () {



            $('#room_request_tbl').DataTable({
                ajax: {
                    url: "{{ route('get_room_approval_data') }}",

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

                        data: "admin_action"
                    },


                ],
            });



            $(document).on('click', '.btn_approve', function () {
                alert();
            });

            $(document).on('click', '.btn_show_data', function () {

                $.ajax({
                    url: "retrieve_room_request/" + $(this).data('id'),
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error(e['msg']);
                            return;
                        }
                        $('#approve_by').val('');
                        $('#approve_data_text').val('');
                        $('#view_request_modal').modal('show');
                        $('#view_date_from').val(e['data']['date_from']);
                        $('#view_date_to').val(e['data']['date_to']);
                        $('#view_room_name').val(e['data']['room_id']);
                        $('#view_events').val(e['data']['event_id']);
                        $('#view_purpose').val(e['data']['remarks']);
                        $('#status').val(e['data']['request_status']);
                        if (e['data']['get_approved_data']) {
                            $('#approve_by').val(e['data']['get_approved_data']['firstname'] + ' ' + e['data']['get_approved_data']['lastname']);
                            $('#approve_data_text').val(e['data']['approve_date']);

                        }





                    }
                });





            });


            $(document).on('click', '.btn_approved', function () {
                if ($(this).data('val') == 1) {
                    var approve = 'Approved';
                }
                else {
                    var approve = 'Disapprove';

                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to ' + approve + ' this request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {


                        $.ajax({
                            url: "approved_room_request/" + $(this).data('id') + '/' + $(this).data('val'),
                            success: function (e) {
                                if (e['isValid'] == false) {
                                    alertify.error(e['msg']);
                                    return;
                                }
                                Swal.fire('Success!', 'The request has been Process.', 'success');
                                $('#room_request_tbl').DataTable().ajax.reload();
                            }

                        })

                    } else {

                    }
                });
            })



            // $('.test').on('click', function () {
            //     alert();
            // })



        })
    </script>

@endsection