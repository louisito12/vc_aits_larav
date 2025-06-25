@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Area</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Area</li>
                </ol>
            </nav>
        </div>

    </div>


    <!-- Page Header Close -->


    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Roles</div>
                    <button id="add_request_btn" class="btn btn-success m-3">Assign Area</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbl_roles" class="table table-bordered text-nowrap table-sm text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Fullname</th>
                                    <th class="text-center">Area</th>
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


    <div class="modal fade" id="assign_area_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add area Messenger
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Messenger</label>
                            <select name="" class="form-control spec_input" id="messenger_id">
                                <option value="">Select Messenger</option>
                                @foreach ($messenger as $messengers)
                                    <option value="{{ $messengers->cen_user_id }}">{{ $messengers->fname }}
                                        {{ $messengers->lname }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Area</label>
                            <select name="" class="form-control spec_input" id="area_id">
                                <option value=""> Select Area</option>
                                @foreach ($area as $areas)
                                    <option value="{{ $areas->id }}">{{ $areas->area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save_area_btn" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_assign_area_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add area Messenger
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Messenger</label>
                            <select name="" class="form-control spec_input" id="edit_messenger_id">
                                <option value="">Select Messenger</option>
                                @foreach ($messenger as $messengers)
                                    <option value="{{ $messengers->cen_user_id }}">{{ $messengers->fname }}
                                        {{ $messengers->lname }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Area</label>
                            <select name="" class="form-control spec_input" id="edit_area_id">
                                <option value=""> Select Area</option>
                                @foreach ($area as $areas)
                                    <option value="{{ $areas->id }}">{{ $areas->area }}</option>
                                @endforeach
                            </select>
                            <input type="text" id="hidden_id" hidden>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_save_btn" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>





@endsection

@section('scripts')
    <script>

        $(document).ready(function () {
            function get_columns() {

            }
            $('#tbl_roles').DataTable({
                destroy: true,
                ajax: {
                    url: "{{ route('aits_area_user_data') }}"
                },

                columns: [
                    {
                        data: "messenger"
                    },
                    {
                        data: "area_list"
                    },
                    {
                        data: "action"
                    },
                ]
            });

            $('#add_request_btn').click(function () {
                $('#assign_area_modal').modal('show');
            });

            $('#save_area_btn').click(function () {
                const messenger_id = $('#messenger_id').val();
                const area_id = $('#area_id').val();
                $.ajax({
                    url: "{{ route('aits_save_area_messenger') }}",
                    type: "POST",
                    data: {
                        area_id: area_id, messenger_id: messenger_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        Swal.fire({
                            title: "added!",
                            text: "Your area and Messenger  has been added.",
                            icon: "success"
                        });
                        $('#tbl_roles').DataTable().ajax.reload();

                        $('#messenger_id').val('');
                        $('#area_id').val('');
                        $('#assign_area_modal').modal('hide');
                    }
                })
            });

            $(document).on('click', '.btn_edit', function () {
                $('#edit_assign_area_modal').modal('show');
                $.ajax({
                    url: "aits_show_area_messenger/" + $(this).data('id'),
                    type: "get",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#hidden_id').val(e['data']['id']);
                        $('#edit_messenger_id').val(e['data']['messenger_id']);
                        $('#edit_area_id').val(e['data']['area_id']);
                    }
                })

            })

            $('#edit_save_btn').click(function () {
                const edit_messenger_id = $('#edit_messenger_id').val();
                const edit_area_id = $('#edit_area_id').val();
                const hidden_id = $('#hidden_id').val();
                $.ajax({
                    url: "{{ route('aits_mess_area_edit') }}",
                    type: "POST",
                    data: {
                        id: hidden_id, messenger_id: edit_messenger_id,
                        area_id: edit_area_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        Swal.fire({
                            title: "Updated!",
                            text: "Your area and Messenger  has been Updated.",
                            icon: "success"
                        });
                        $('#tbl_roles').DataTable().ajax.reload();
                        $('#edit_assign_area_modal').modal('hide');
                    }
                })

            });

            $(document).on('click', '.btn_delete', function () {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "aits_mess_area_delete/" + $(this).data('id'),
                            type: "Get",
                            success: function (e) {
                                if (e['isValid'] == false) {
                                    alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                                    return;
                                }
                                $('#tbl_roles').DataTable().ajax.reload();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "the area and messenger  has been deleted.",
                                    icon: "success"
                                });
                            }
                        })
                    }
                });
            });

        });
    </script>

@endsection