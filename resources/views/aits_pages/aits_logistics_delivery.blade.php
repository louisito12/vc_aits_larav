@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Request for Delivery</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Logistics Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Request for Delivery</li>
                </ol>
            </nav>
        </div>



    </div>





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
                        <table id="deliver_tbl" class="table table-bordered text-nowrap table-sm text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Request #</th>

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

    <div class="modal fade" id="add_delivery_request_modal" tabindex="-1" aria-labelledby="exampleModalLgLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Delivery Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label>Receiver Name</label>
                            <input type="text" class="form-control spec_input">
                        </div>
                        <div class="col-4">
                            <label>Company Name</label>
                            <input type="text" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Receiver Contact</label>
                            <input type="text" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Delivery Type</label>
                            <input type="text" class="form-control spec_input">
                        </div>
                        <div class="col-4">
                            <label>Area</label>
                            <input type="text" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Document Counts</label>
                            <input type="text" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Complete Number</label>

                            <textarea class="form-control spec_input" id=""></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control spec_input" id=""></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Attachments</label>
                            <input type="file" name="" class="form-control" id="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add Request</button>
                </div>
            </div>
        </div>
    </div>






@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#deliver_tbl').DataTable();

            $('#add_request_btn').click(function () {
                $('#add_delivery_request_modal').modal('show');
            });






        });

































        // $('.get_value').change(function () {
        //     const array_id = [];
        //     $('.get_value:checked').each(function () {
        //         array_id.push($(this).val());
        //     });
        //     console.log(array_id)
        // });
        // $('.get_value').on('change', function () {
        //     const selectedValues = [];

        //     $('.get_value').each(function () {
        //         if ($(this).prop('checked')) {
        //             selectedValues.push($(this).val());
        //         }
        //     });

        //     console.log(selectedValues);
        // });

        // $('.get_value').on('change', function () {
        //     const selectedValues = [];
        //     const checkboxes = $('.get_value');

        //     for (let i = 0; i < checkboxes.length; i++) {
        //         const checkbox = checkboxes[i];
        //         if ($(checkbox).prop('checked')) {
        //             selectedValues.push($(checkbox).val());
        //         }
        //     }

        //     console.log(selectedValues);
        // });

    </script>
@endsection