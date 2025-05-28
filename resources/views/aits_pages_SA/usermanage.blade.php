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
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Username</th>


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



    <div class="modal fade" id="add_roles_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add Roles
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Add Roles</label>
                    <input class="form-control" id="roles" type="text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save_roles_btn" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_roles_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="approve_data_header"> Add Roles
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Add Roles</label>
                    <input class="form-control" id="edit_roles" type="text">
                    <input class="form-control" hidden id="edit_id" type="text">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_roles_btn" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('#tbl_users').DataTable();
        })
    </script>
@endsection