@extends('aits_main_page')



@section('content')

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
                                        <th>Date Requested</th>
                                        <th>Requested By</th>
                                        <th>Department</th>
                                        <th>Date Schedule</th>
                                        <th>Type</th>
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
                            <input type="datetime-local" id="departure_date" class="spec_input form-control ">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Appointment Date</label>
                            <input type="datetime-local" id="appointment_date" class="spec_input form-control">
                        </div>
                        <div class="col-2 purpose_col">
                            <label>Pick Up Date</label>
                            <input type="datetime-local" id="pickup_date" class="spec_input form-control">
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
                            <label>Manager Approval</label>
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


    <!-- Modal end -->





@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#tbl_transit').DataTable();

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
                add_shuttle_data.append('departure_date', departure_date);
                add_shuttle_data.append('appointment_date', appointment_date);
                add_shuttle_data.append('pickup_date', pickup_date);
                add_shuttle_data.append('client_name', client_name);
                add_shuttle_data.append('type', purpose);
                add_shuttle_data.append('purpose', other_purpose);
                add_shuttle_data.append('passenger_number', number_pass);
                add_shuttle_data.append('client_name', client_name);
                add_shuttle_data.append('manager_id', manager_app);
                add_shuttle_data.append('passenger_number', number_pass);
                add_shuttle_data.append('destination', destination);
                add_shuttle_data.append('file', ob_form_file);



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
                })




            });



            $('#purpose').change(function () {
                if ($(this).val() === 'remarks') {
                    $('.purpose_column_hidden').removeAttr('hidden');
                }
                else {
                    $('.purpose_column_hidden').attr('hidden', true);
                }
            });

        });
    </script>

@endsection