@extends('aits_main_page')
@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">PMS Management</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">PMS Management</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->


    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">PMS Management</div>
                    <button id="add_pms_btn" class="btn btn-success m-3">Add PMS</button>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tbl_pms" class="table table-bordered text-nowrap table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-center">PMS Name</th>
                                            <th class="text-center">PMS Description</th>
                                            <th class="text-center">PMS Scheudle</th>
                                            <th class="text-center">PMS Start</th>
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
        </div>
    </div>




    <!-- Modals -->


    <div class="modal fade" id="add_pms_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add PMS
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                            <label>PMS Name</label>
                            <input type="text" class="form-control spec_input" id="pms_name">
                        </div>

                        <div class="col-4">
                            <label>PMS Start </label>
                            <input type="date" class="form-control spec_input" id="pms_start">
                        </div>
                        <div class="col-4">
                            <label>PMS Schedule</label>
                            <select class="form-control spec_input" id="pms_type">
                                <option value="">Select Schedule</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Annually</option>
                                <option value="quarterly">Quarterly</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>PMS Description</label>

                            <textarea class="form-control spec_input" id="pms_description"></textarea>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add_pms_save" class="btn btn-primary">Add PMS</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="edit_pms_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add PMS
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4">
                            <label>PMS Name</label>
                            <input type="text" class="form-control spec_input" id="edit_pms_name">
                            <input type="text" class="form-control spec_input" hidden id="edit_id">

                        </div>

                        <div class="col-4">
                            <label>PMS Start </label>
                            <input type="date" class="form-control spec_input" id="edit_date_start">
                        </div>
                        <div class="col-4">
                            <label>PMS Schedule</label>
                            <select class="form-control spec_input" id="edit_pms_date_types">
                                <option value="">Select Schedule</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Annually</option>
                                <option value="quarterly">Quarterly</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>PMS Description</label>

                            <textarea class="form-control spec_input" id="edit_pms_description"></textarea>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add_pms_save" class="btn btn-primary">Edit PMS</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->








@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#add_pms_btn').click(function () {
                $('#add_pms_modal').modal('show');
            });


            $('#tbl_pms').DataTable({
                destroy: true,
                ajax: {
                    url: "{{ route('get_pms_data') }}",
                },


                columns: [
                    {
                        data: "pms_name"
                    },
                    {
                        data: "pms_description"
                    },

                    {
                        data: "pms_date_types"
                    },

                    {
                        data: "date_start"
                    },
                    {
                        data: "action"
                    },
                ],
            });


            $('#add_pms_save').click(function () {
                const pms_name = $('#pms_name').val();
                const pms_start = $('#pms_start').val();
                const pms_type = $('#pms_type').val();
                const pms_description = $('#pms_description').val();


                $.ajax({
                    url: "{{ route('save_pms_request') }}",
                    type: "POST",
                    data: {
                        pms_name: pms_name, pms_description: pms_description,
                        pms_date_types: pms_type, date_start: pms_start,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.set('notifier', 'delay', 5);
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            // alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }

                        $('#pms_name').val('');
                        $('#pms_start').val('');
                        $('#pms_type').val('');
                        $('#pms_description').val('');
                        $('#add_pms_modal').modal('hide');
                        $('#tbl_pms').DataTable().ajax.reload();
                        Swal.fire('Success!', 'Your request has been successfully added.', 'success');

                    }
                })
            });

            $(document).on('click', '.btn_edit', function () {
                $.ajax({
                    url: "get_pms_details/" + $(this).data('id'),
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {

                            alertify.set('notifier', 'position', 'top-right');
                            alertify.set('notifier', 'delay', 5);
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            // alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#edit_pms_modal').modal('show');

                        $('#edit_pms_name').val(e['data']['pms_name']);
                        $('#edit_id').val(e['data']['id']);
                        $('#edit_pms_date_types').val(e['data']['pms_date_types']);
                        $('#edit_pms_description').val(e['data']['pms_description']);
                        $('#edit_date_start').val(e['data']['date_start']);




                    }
                })
            })


        });

    </script>
@endsection