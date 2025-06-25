@extends('aits_main_page')
<style>
    .input-container {
        position: relative;
        display: inline-block;
    }

    .clear-btn {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #888;
        font-size: 16px;
        cursor: pointer;
        padding: 0;
    }

    .clear-btn:focus {
        outline: none;
    }

    textarea {
        padding-right: 30px;
        /* Space for the button */
    }
</style>
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
                    <div class="col d-flex justify-content-end">
                        <div hidden class="input-group input-group-sm w-25">
                            <button id="view_tbl_pms" class="btn  btn-info">View PMS</button>
                            <select name="" id="pms_year" class="form-select ">
                                <!-- options from now minu 10 years and plus 1 from year now -->
                                @php
                                    $currentYear = date('Y');
                                 @endphp
                                @for($i = $currentYear - 10; $i <= $currentYear + 1; $i++)
                                    <option value={{ $i }}>{{ $i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
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
                                            <th class="text-center">Conducted By</th>
                                            <th class="text-center">Noted By</th>
                                            <th class="text-center"> PMS Action</th>
                                            <th class="text-center"> PMS Status </th>
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
                        <di class="col-6">
                            <label>Noted By</label>
                            <select id="noted_by" class="form-control spec_input"></select>
                        </di>
                        <div class="col-6">
                            <label>Conducted By</label>
                            <input id="conducted_by" type="text" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>PMS Description</label>
                            <textarea class="form-control spec_input" id="pms_description"></textarea>
                        </div>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input radio_btn" type="radio" name="selection" id="email"
                                    value="1">
                                <label class="form-check-label" for="email">Email</label>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input radio_btn" type="radio" name="selection" id="system_only"
                                    value="2">
                                <label class="form-check-label" for="system_only">System Only</label>
                                <input type="text" name="" hidden id="is_email">
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row send_to_row">
                        <div class="col-12">
                            <label>Send to</label>
                            <select id="send_to" class="form-control  select2" multiple="multiple">

                            </select>
                        </div>

                        <div class="col-12">
                            <label>CC to</label>
                            <select id="cc_to" class="form-control  select2" multiple="multiple">

                            </select>
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

                    <br>



                    <br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input radio_btn" type="radio" name="edit_selection" id="email"
                                    value="1">
                                <label class="form-check-label" for="email">Email</label>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input radio_btn" type="radio" name="edit_selection"
                                    id="system_only" value="2">
                                <label class="form-check-label" for="system_only">System Only</label>
                                <input type="text" name="" hidden id="edit_is_email">
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row edit_send_to_row">
                        <div class="col-12">
                            <label>Send to</label>
                            <select id="edit_send_to" class="form-control  select2" multiple="multiple">
                            </select>
                        </div>

                        <div class="col-12">
                            <label>CC to</label>
                            <select id="edit_cc_to" class="form-control  select2" multiple="multiple">
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_pms_btn" class="btn btn-primary">Edit PMS</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="add_pms_remarks_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="pms_text_header">
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <label>PMS Remarks</label>
                            <textarea class="form-control spec_input" id="pms_remarks"></textarea>
                            <input type="text" class="form-control spec_input" hidden id="pms_hid_id">

                        </div>

                        <div class="col-6">
                            <label>PMS File</label>
                            <input type="file" class="form-control spec_input" id="pms_files">
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save_remarks_pms" class="btn btn-primary">Save PMS</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->




    <div class="modal fade" id="view_pms_data" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="pms_text_header">PMS View 2025
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered" id="pms_sched_table">
                                <thead>
                                    <tr>
                                        <th scope="col">PMS Name</th>
                                        <th scope="col">Schedule</th>
                                        <th scope="col">JAN</th>
                                        <th scope="col">FEB</th>
                                        <th scope="col">MAR</th>
                                        <th scope="col">APR</th>
                                        <th scope="col">MAY</th>
                                        <th scope="col">JUN</th>
                                        <th scope="col">JUL</th>
                                        <th scope="col">AUG</th>
                                        <th scope="col">SEP</th>
                                        <th scope="col">OCT</th>
                                        <th scope="col">NOV</th>
                                        <th scope="col">DEC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>


                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </tbody>
                            </table>

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
            $('#tbl_pms').DataTable({
                destroy: true,
                ajax: {
                    url: "{{ route('get_pms_approval') }}",
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
                        data: "conducted_by"
                    },
                    {
                        data: "noted_by"
                    },
                    {
                        data: "pms_status"
                    },
                    {
                        data: "pms_status_badge"
                    },
                    {
                        data: "approval_action"
                    },
                ],
            });

            $(document).on('click', '.btn_approved', function () {


                if ($(this).data('val') == 1) {
                    var approve = 'Approve';
                }
                else {
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
                                    url: "approved_pms/" + $(this).data('id') + "/" + $(this).data('val') + '/' + remarks,
                                    success: function (e) {
                                        if (e['isValid'] == false) {
                                            Swal.fire({
                                                icon: 'error',
                                                html: '<span style="color: white;">' + e['msg'] + '</span>',
                                                background: '#f27474',
                                                timer: 5000,
                                                showConfirmButton: false,
                                                timerProgressBar: true,
                                                toast: false,
                                            })
                                            reject('Deletion failed');
                                        }
                                        else {
                                            Swal.fire({
                                                title: approve + '!',
                                                text: "Your request has been " + approve,
                                                icon: "success"
                                            });
                                            $('#tbl_pms').DataTable().ajax.reload();
                                            resolve();
                                        }
                                    },
                                });
                            }
                        });
                    }
                })


            })
        })
    </script>
@endsection