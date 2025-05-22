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
                                    <th class="text-center">Client Name </th>
                                    <th class="text-center">Company Name </th>


                                    <th class="text-center">Department </th>

                                    <th class="text-center">Action </th>


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
                            <input type="text" id="name_receiver" class="form-control spec_input">
                        </div>
                        <div class="col-4">
                            <label>Company Name</label>
                            <input type="text" id="company_name" class="form-control spec_input">

                        </div>
                        <div class="col-4">
                            <label>Receiver Contact</label>
                            <input type="text" id="contact_receiver" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label>Delivery Type</label>
                            <select id="delivery_type_id" class="form-control spec_input">
                                <option value="">Select Delivery Type</option>
                                @foreach ($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->del_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Area</label>
                            <select name="" id="area_id" class="form-control spec_input">
                                <option value="">Select Area</option>
                                @foreach ($area as $areas)
                                    <option value="{{ $areas->id }}">{{ $areas->area }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-4">
                            <label>Document Counts</label>
                            <input type="number" id="count_documents" class="form-control spec_input">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Complete Address</label>

                            <textarea class="form-control spec_input" id="complete_address"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control spec_input" id="delivery_remarks"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Attachments</label>
                            <input type="file" name="" class="form-control" id="del_file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn_delivery" class="btn btn-primary">Add Request</button>
                </div>
            </div>
        </div>
    </div>






@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#deliver_tbl').DataTable({
                ajax: {
                    url: "{{ route('show_delivery_request') }}"
                },
                columns: [
                    {
                        data: "request_no"
                    },
                    {
                        data: "name_receiver"
                    },
                    {
                        data: "company_name"
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
                $('#add_delivery_request_modal').modal('show');
            });

            $('#btn_delivery').click(function () {
                const name_receiver = $('#name_receiver').val();
                const company_name = $('#company_name').val();
                const contact_receiver = $('#contact_receiver').val();
                const delivery_type_id = $('#delivery_type_id').val();
                const area_id = $('#area_id').val();
                const count_documents = $('#count_documents').val();
                const complete_address = $('#complete_address').val();
                const delivery_remarks = $('#delivery_remarks').val();
                const file = $('#del_file')[0].files[0];


                if (name_receiver == "" || company_name == "" || contact_receiver == "" ||
                    delivery_type_id == "" || area_id == "" || count_documents == "" ||
                    complete_address == "" || delivery_remarks == "" || file == undefined || file == ""
                ) {

                    alertify.error('<span style="color: white;">All fields Required !</span>');
                    return;
                }

                const form_data = new FormData();
                form_data.append('name_receiver', name_receiver);
                form_data.append('company_name', company_name);
                form_data.append('contact_receiver', contact_receiver);
                form_data.append('delivery_type_id', delivery_type_id);
                form_data.append('area_id', area_id);
                form_data.append('count_documents', count_documents);
                form_data.append('complete_address', complete_address);
                form_data.append('delivery_remarks', delivery_remarks);
                form_data.append('file[]', file);

                $.ajax({
                    url: "{{ route('aits_save_delivery') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: form_data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                    },
                    success: function (e) {
                        if (e['isValid'] == false) {
                            alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                            return;
                        }
                        $('#add_delivery_request_modal').modal('hide');
                        $('#name_receiver').val('');
                        $('#company_name').val('');
                        $('#contact_receiver').val('');
                        $('#delivery_type_id').val('');
                        $('#area_id').val('');
                        $('#count_documents').val('');
                        $('#complete_address').val('');
                        $('#delivery_remarks').val('');
                        $('#del_file').val('');
                        $('#deliver_tbl').DataTable().ajax.reload();
                        Swal.fire('Success!', 'Your request has been successfully added.', 'success');

                    

                    }
                })







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