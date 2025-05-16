@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Vehicle Management</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Service Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vehicle Management</li>
                </ol>
            </nav>
        </div>


    </div>

    <style>
        #tbl_car th,
        #tbl_car td {
            text-align: center !important;
            vertical-align: middle;
        }
    </style>

    <!-- Page Header Close -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Shuttle Request</div>
                    <button id="add_request_btn" class="btn btn-success m-3 ">Add Car</button>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table id="tbl_car" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Vehicle Model</th>
                                        <th>Brand</th>
                                        <th>Plate Number</th>
                                        <th> Expiry</th>
                                        <th> Status</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Add Vehicle
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                            <label>Brand</label>
                            <input type="text" id="brand" class="spec_input form-control ">
                        </div>
                        <div class="col-4">
                            <label>Vehicle Model</label>
                            <input type="text" id="model" class="spec_input form-control">
                        </div>
                        <div class="col-4">
                            <label>Plate Number</label>
                            <input type="text" id="plate_number" class="spec_input form-control">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Registry Date</label>
                            <input type="date" id="registry_date" class="spec_input form-control">
                        </div>
                        <div class="col-6">
                            <label>Registry Expiry</label>
                            <input type="date" id="registry_expiry" class="spec_input form-control">
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




    <div class="modal fade" id="edit_vehicle_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Edit Vehicle
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                            <label>Brand</label>
                            <input type="text" id="edit_brand" class="spec_input form-control ">
                            <input type="text" id="edit_id" hidden class="spec_input form-control ">
                        </div>
                        <div class="col-4">
                            <label>Vehicle Model</label>
                            <input type="text" id="edit_model" class="spec_input form-control">
                        </div>
                        <div class="col-4">
                            <label>Plate Number</label>
                            <input type="text" id="edit_plate_number" class="spec_input form-control">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Registry Date</label>
                            <input type="date" id="edit_registry_date" class="spec_input form-control">
                        </div>
                        <div class="col-6">
                            <label>Registry Expiry</label>
                            <input type="date" id="edit_registry_expiry" class="spec_input form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="update_vehicle_btn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="view_vehicle_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Edit Vehicle
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                            <label>Brand</label>
                            <input disabled type="text" id="view_brand" class="spec_input form-control ">

                        </div>
                        <div class="col-4">
                            <label>Vehicle Model</label>
                            <input disabled type="text" id="view_model" class="spec_input form-control">
                        </div>
                        <div class="col-4">
                            <label>Plate Number</label>
                            <input disabled type="text" id="view_plate_number" class="spec_input form-control">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Registry Date</label>
                            <input disabled type="date" id="view_registry" class="spec_input form-control">
                        </div>
                        <div class="col-6">
                            <label>Registry Expiry</label>
                            <input disabled type="date" id="view_expiry" class="spec_input form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Vehicle Operation -->

    <div class="modal fade" id="add_operation_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Edit Vehicle
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                            <label>Brand</label>
                            <input disabled type="text" id="view_brand_operation" class="spec_input form-control ">

                        </div>
                        <div class="col-4">
                            <label>Vehicle Model</label>
                            <input disabled type="text" id="view_model_operation" class="spec_input form-control">
                        </div>
                        <div class="col-4">
                            <label>Plate Number</label>
                            <input disabled type="text" id="view_plate_number_operation" class="spec_input form-control">
                        </div>

                    </div>
                    <br>
                    <div class="row">

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
            $('#tbl_car').DataTable({
                ajax: {
                    url: "{{ route('get_vehicle_data') }}",
                },
                columns: [
                    {
                        data: "brand"
                    },
                    {
                        data: "model"
                    },
                    {
                        data: "plate_number"
                    },
                    {
                        data: "expiry_date"
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
                const brand = $('#brand').val();
                const model = $('#model').val();
                const plate_number = $('#plate_number').val();
                const registry_date = $('#registry_date').val();
                const registry_expiry = $('#registry_expiry').val();

                if (brand == "" || model == "" || plate_number == "" || registry_date == "" || registry_expiry == "") {
                    alertify.error('<span style="color: white;"> All fileds is required </span>');
                    return;
                }


                $.ajax({
                    url: "{{ route('save_vehicle') }}",
                    type: "POST",
                    data: {
                        brand: brand,
                        model: model,
                        plate_number: plate_number,
                        start_date: registry_date,
                        expiry_date: registry_expiry

                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (e) {
                        Swal.fire({
                            title: "Success!",
                            text: "The car  has been added.",
                            icon: "success"
                        });
                        $('#tbl_car').DataTable().ajax.reload();
                        $('#brand').val("");
                        $('#model').val("");
                        $('#plate_number').val("");
                        $('#registry_date').val("");
                        $('#registry_expiry').val("");
                    }
                });

            });


            $(document).on('click', '.btn_edit', function () {


                $.ajax({
                    url: "get_car_details/" + $(this).data('id'),
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }

                        $('#edit_id').val(e['data']['id'])
                        $('#edit_brand').val(e['data']['brand'])
                        $('#edit_model').val(e['data']['model'])
                        $('#edit_plate_number').val(e['data']['plate_number'])
                        $('#edit_registry_date').val(e['data']['start_date'])
                        $('#edit_registry_expiry').val(e['data']['expiry_date'])
                        $('#edit_vehicle_modal').modal('show')

                    }
                })
            });

            $('#update_vehicle_btn').click(function () {
                const edit_id = $('#edit_id').val()
                const edit_brand = $('#edit_brand').val()
                const edit_model = $('#edit_model').val()
                const edit_plate_number = $('#edit_plate_number').val()
                const edit_registry_date = $('#edit_registry_date').val()
                const edit_registry_expiry = $('#edit_registry_expiry').val()

                if (edit_brand == "" || edit_model == "" || edit_plate_number == "" || edit_registry_date == "" || edit_registry_expiry == "") {
                    alertify.error('<span style="color: white;"> All fileds is required </span>');
                    return;
                }


                $.ajax({
                    url: "{{ route('edit_vehicle') }}",
                    type: "POST",
                    data: {
                        id: edit_id, brand: edit_brand,
                        model: edit_model, plate_number: edit_plate_number,
                        start_date: edit_registry_date, expiry_date: edit_registry_expiry,

                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (e) {
                        $('#edit_vehicle_modal').modal('hide')
                        Swal.fire({
                            title: "Success!",
                            text: "The car  has been Edited.",
                            icon: "success"
                        });
                        $('#tbl_car').DataTable().ajax.reload();


                    }
                })

            });


            $(document).on('click', '.btn_view', function () {

                $.ajax({
                    url: "get_car_details/" + $(this).data('id'),
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }

                        $('#view_vehicle_modal').modal('show');
                        $('#view_brand').val(e['data']['brand'])
                        $('#view_model').val(e['data']['model'])
                        $('#view_plate_number').val(e['data']['plate_number'])
                        $('#view_registry').val(e['data']['start_date'])
                        $('#view_expiry').val(e['data']['expiry_date'])


                    }
                })
            });


        });
    </script>

@endsection