@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Users</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>

    </div>


    <!-- Page Header Close -->


    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Users</div>
                    <button id="add_request_btn" class="btn btn-success m-3">Add User</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbl_users" class="table table-bordered text-nowrap table-sm text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Fullname</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Department</th>
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



    <div class="modal fade" id="add_users_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add User
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <label>First Name</label>
                            <input type="text" class="form-control spec_input" id="firstname">
                        </div>
                        <div class="col-3">
                            <label>Middle Name</label>
                            <input type="text" class="form-control spec_input" id="middlename">
                        </div>
                        <div class="col-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control spec_input" id="lastname">
                        </div>
                        <div class="col-3">
                            <label>Suffix</label>
                            <select name="" class="form-control spec_input" id="suffix_id">
                                <option value="">Select Suffix</option>
                                @foreach ($suffix as $suffixs)
                                    <option value="{{ $suffixs->id }}">{{ $suffixs->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3">
                            <label>Birthday</label>
                            <input type="date" class="form-control spec_input" id="birthdate">
                        </div>
                        <div class="col-3">
                            <label>Citizenship</label>
                            <select class="form-control spec_input" id="citizenship_id">
                                <option value="">Select Citizenship</option>
                                @foreach ($citizen as $citizens)
                                    <option value="{{ $citizens->id }}">{{ $citizens->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Department</label>
                            <select class="form-control spec_input" id="department_id">
                                <option value="">Please Select Department</option>
                                @foreach ($department as $departments)
                                    <option value="{{ $departments->id }}">{{ $departments->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Civil Status</label>
                            <select name="" class="form-control spec_input" id="civil_status_id">
                                <option value="">Please Select Civil Status</option>
                                @foreach ($civil as $civils)
                                    <option value="{{ $civils->id}}">{{ $civils->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-2">
                            <label>Gender</label>
                            <select class="form-control spec_input" id="gender_id">
                                <option value="">Please Select Gender</option>
                                @foreach ($gender as $genders)
                                    <option value="{{ $genders->id }}">{{ $genders->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label> Email</label>
                            <input type="email" class="form-control spec_input" id="user_email">
                        </div>
                        <div class="col-2">
                            <label> Contact Number</label>
                            <input type="email" class="form-control spec_input" id="contact_no">
                        </div>
                        <div class="col-2">
                            <label> Position Name</label>
                            <input type="text" class="form-control spec_input" id="user_title">
                        </div>

                        <div class="col-2">
                            <label>Username</label>
                            <input type="text" id="username" class="form-control spec_input">
                        </div>

                        <div class="col-2">
                            <label>Password</label>
                            <input type="password" id="password" class="form-control spec_input">

                        </div>

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label><strong>Select Roles:</strong></label>
                                <div class="d-flex flex-wrap">
                                    @foreach ($role as $roles)
                                        <div class="form-check me-3 mb-2" style="min-width: 150px;">
                                            <input class="form-check-input get_role" type="checkbox" value="{{ $roles->id }}"
                                                id="role_{{ $roles->id }}" name="roles[]">
                                            <label class="form-check-label" for="role_{{ $roles->id }}">
                                                {{ $roles->role }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save_user_btn" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="edit_users_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add User
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <label>First Name</label>
                            <input type="text" class="form-control spec_input" id="edit_firstname">
                        </div>
                        <div class="col-3">
                            <label>Middle Name</label>
                            <input type="text" class="form-control spec_input" id="edit_middlename">
                        </div>
                        <div class="col-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control spec_input" id="edit_lastname">
                        </div>
                        <div class="col-3">
                            <label>Suffix</label>
                            <select name="" class="form-control spec_input" id="edit_suffix_id">
                                <option value="">Select Suffix</option>
                                @foreach ($suffix as $suffixs)
                                    <option value="{{ $suffixs->id }}">{{ $suffixs->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3">
                            <label>Birthday</label>
                            <input type="date" class="form-control spec_input" id="edit_birthdate">
                        </div>
                        <div class="col-3">
                            <label>Citizenship</label>
                            <select class="form-control spec_input" id="edit_citizenship_id">
                                <option value="">Select Citizenship</option>
                                @foreach ($citizen as $citizens)
                                    <option value="{{ $citizens->id }}">{{ $citizens->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Department</label>
                            <select class="form-control spec_input" id="edit_department_id">
                                <option value="">Please Select Department</option>
                                @foreach ($department as $departments)
                                    <option value="{{ $departments->id }}">{{ $departments->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Civil Status</label>
                            <select name="" class="form-control spec_input" id="edit_civil_status_id">
                                <option value="">Please Select Civil Status</option>
                                @foreach ($civil as $civils)
                                    <option value="{{ $civils->id}}">{{ $civils->description }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-2">
                            <label>Gender</label>
                            <input type="text" hidden id="edit_id">
                            <select class="form-control spec_input" id="edit_gender_id">
                                <option value="">Please Select Gender</option>
                                @foreach ($gender as $genders)
                                    <option value="{{ $genders->id }}">{{ $genders->description }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label> Email</label>
                            <input type="email" class="form-control spec_input" id="edit_user_email">
                        </div>
                        <div class="col-2">
                            <label> Contact Number</label>
                            <input type="email" class="form-control spec_input" id="edit_contact_no">
                        </div>
                        <div class="col-2">
                            <label> Position Name</label>
                            <input type="text" class="form-control spec_input" id="edit_user_title">
                        </div>

                        <div class="col-2">
                            <label>Username</label>
                            <input type="text" id="edit_username" class="form-control spec_input">
                        </div>

                        <!-- <div class="col-2">
                                                                                                                                                                                      <label>Passworod</label>
                                                                                                                                                                                     <input type="password" id="edit_password" class="form-control spec_input"></div> -->

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label><strong>Select Roles:</strong></label>
                                <div class="d-flex flex-wrap">
                                    @foreach ($role as $roles)
                                        <div class="form-check me-3 mb-2" style="min-width: 150px;">
                                            <input class="form-check-input update_role" type="checkbox" value="{{ $roles->id }}"
                                                id="role_{{ $roles->id }}" name="roles[]">
                                            <label class="form-check-label" for="role_{{ $roles->id }}">
                                                {{ $roles->role }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_user_btn" class="btn btn-info">Edit</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('#tbl_users').DataTable({
                serverSide: true,

                ajax: {
                    url: "{{ route('show_users') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                },
                columns: [
                    {
                        data: "fullname"
                    },
                    {
                        data: "username"
                    },
                    {
                        data: "department"
                    },
                    {
                        data: "action"
                    },
                ]
            });


            $('#add_request_btn').click(function () {
                $('#add_users_modal').modal('show');

            });


            $('#save_user_btn').click(function () {
                const username = $('#username').val();
                const user_email = $('#user_email').val();
                const password = $('#password').val();
                const firstname = $('#firstname').val();
                const middlename = $('#middlename').val();
                const lastname = $('#lastname').val();
                const suffix_id = $('#suffix_id').val();
                const birthdate = $('#birthdate').val();
                const gender_id = $('#gender_id').val();
                const department_id = $('#department_id').val();
                const civil_status_id = $('#civil_status_id').val();
                const citizenship_id = $('#citizenship_id').val();
                const user_title = $('#user_title').val();
                const contact_no = $('#contact_no').val();
                const roles_arr = [];

                $('.get_role:checked').each(function () {
                    roles_arr.push($(this).val());
                });


                if (update_roles.length == 0) {
                    roles_arr.error('<span style="color: white;">Please Select roles </span>');
                    return;
                }



                $.ajax({
                    url: "{{ route('aits_save_user') }}",
                    type: "POST",
                    data: {
                        username, user_email, password, firstname, middlename, lastname,
                        suffix_id, birthdate, gender_id, department_id, civil_status_id,
                        user_title, citizenship_id, contact_no, roles_arr
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }


                        $('.get_role').prop('checked', false);
                        $('#add_users_modal').modal('hide');
                        $('#username').val('');
                        $('#user_email').val('');
                        $('#password').val('');
                        $('#firstname').val('');
                        $('#middlename').val('');
                        $('#lastname').val('');
                        $('#suffix_id').val('');
                        $('#birthdate').val('');
                        $('#gender_id').val('');
                        $('#department_id').val('');
                        $('#civil_status_id').val('');
                        $('#citizenship_id').val();
                        $('#user_title').val('');
                        $('#contact_no').val('');
                        $('#tbl_users').DataTable().ajax.reload();
                        Swal.fire({
                            title: "added!",
                            text: "Your  user has been added.",
                            icon: "success"
                        });

                    }

                })

            })


            $(document).on('click', '.btn_edit', function () {
                const data_id = $(this).data('id');
                $('.update_role').prop('checked', false);
                $.ajax({
                    url: "get_user_info/" + data_id,
                    type: "GET",
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }


                        var selectedRoles = e['data']['role'];
                        for (let i = 0; i < selectedRoles.length; i++) {
                            let roleId = selectedRoles[i];
                            $('.update_role').each(function () {
                                if (parseInt($(this).val()) === parseInt(roleId)) {
                                    $(this).prop('checked', true);
                                }
                            });
                        }
                        $('#edit_users_modal').modal('show');
                        $('#edit_username').val(e['data']['username']);
                        $('#edit_user_email').val(e['data']['user_email']);
                        $('#edit_firstname').val(e['data']['get_user_data']['firstname']);
                        $('#edit_middlename').val(e['data']['get_user_data']['middlename']);
                        $('#edit_lastname').val(e['data']['get_user_data']['lastname']);
                        $('#edit_suffix_id').val(e['data']['get_user_data']['suffix_id']);
                        $('#edit_birthdate').val(e['data']['get_user_data']['birthdate']);
                        $('#edit_gender_id').val(e['data']['get_user_data']['gender_id']);
                        $('#edit_department_id').val(e['data']['get_user_data']['deparment_id']);
                        $('#edit_civil_status_id').val(e['data']['get_user_data']['civil_status_id']);
                        $('#edit_citizenship_id').val(e['data']['get_user_data']['citizenship_id']);
                        $('#edit_user_title').val(e['data']['get_user_data']['user_title']);
                        $('#edit_contact_no').val(e['data']['contact_no']);
                        $('#edit_id').val(e['data']['id'])


                    }
                })
            })



            $('#edit_user_btn').click(function () {
                const edit_username = $('#edit_username').val();
                const edit_user_email = $('#edit_user_email').val();
                // const edit_password = $('#edit_password').val();
                const edit_firstname = $('#edit_firstname').val();
                const edit_middlename = $('#edit_middlename').val();
                const edit_lastname = $('#edit_lastname').val();
                const edit_suffix_id = $('#edit_suffix_id').val();
                const edit_birthdate = $('#edit_birthdate').val();
                const edit_gender_id = $('#edit_gender_id').val();
                const edit_department_id = $('#edit_department_id').val();
                const edit_civil_status_id = $('#edit_civil_status_id').val();
                const edit_citizenship_id = $('#edit_citizenship_id').val();
                const edit_user_title = $('#edit_user_title').val();
                const edit_contact_no = $('#edit_contact_no').val();
                const edit_id = $('#edit_id').val();
                const update_roles = [];

                $('.update_role:checked').each(function () {
                    update_roles.push($(this).val());
                });


                if (update_roles.length == 0) {
                    alertify.error('<span style="color: white;">Please Select roles </span>');
                    return;
                }
                $.ajax({
                    url: "{{ route('aits_edit_user') }}",
                    type: "POST",
                    data: {
                        username: edit_username,
                        user_email: edit_user_email,
                        // password: edit_password,
                        firstname: edit_firstname,
                        middlename: edit_middlename,
                        lastname: edit_lastname,
                        id: edit_id,
                        suffix_id: edit_suffix_id,
                        birthdate: edit_birthdate,
                        gender_id: edit_gender_id,
                        department_id: edit_department_id,
                        civil_status_id: edit_civil_status_id,
                        user_title: edit_user_title,
                        citizenship_id: edit_citizenship_id,
                        contact_no: edit_contact_no, update_roles
                    },

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#edit_users_modal').modal('hide');
                        $('.update_role').prop('checked', false);
                        $('#tbl_users').DataTable().ajax.reload();
                        Swal.fire({
                            title: "updated!",
                            text: "Your  user has been updated.",
                            icon: "success"
                        });
                    }
                });
            })


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
                            url: "users_delete/" + $(this).data('id'),
                            type: "GET",
                            success: function (e) {
                                if (e['isValid'] == false) {
                                    alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                                    return;
                                }
                                $('#tbl_users').DataTable().ajax.reload();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "The user has been deleted.",
                                    icon: "success"
                                });
                            }
                        })
                    }
                });
            })

        })
        //535,654
    </script>
@endsection