@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">User Management</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Service Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Management</li>
                </ol>
            </nav>
        </div>

    </div>


    <!-- Page Header Close -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">User Management</div>
                    <button id="add_user_btn" class="btn btn-success m-3 ">Add User</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="user_tbl" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="spec_input w-25">Full Name</th>
                                    <th class="spec_input w-25">Department</th>
                                    <th class="spec_input w-25">Position</th>
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
    <div class="modal fade" id="add_user_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Add User
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>First Name</label>
                            <input id="first_name" type="text" class="form-control spec_input">
                        </div>

                        <div class="col-6">
                            <label>Middle Name</label>
                            <input id="middle_name" type="text" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Last Name</label>
                            <input id="last_name" type="text" class="form-control spec_input">
                        </div>
                        <div class="col-6">
                            <label>Department</label>
                            <input id="department" type="text" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label>Postion</label>
                            <input id="position" type="text" class="form-control spec_input">
                        </div>
                        <div class="col-6">
                            <label>Email</label>
                            <input id="email" type="email" class="form-control spec_input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- end user -->

@endsection


@section('scripts')


    <script>
        $(document).ready(function () {
            $('#user_tbl').DataTable()

            $('#add_user_btn').click(function () {
                $('#add_user_modal').modal('show')
            });

        });
    </script>
@endsection