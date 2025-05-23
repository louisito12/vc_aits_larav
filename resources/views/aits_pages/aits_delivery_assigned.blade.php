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

    <style>
        #deliver_tbl th,
        #deliver_tbl td {
            text-align: center !important;
            vertical-align: middle;
            font-size: 0.8em;
        }
    </style>




    <!-- Page Header Close -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3"> Assign Delivery</div>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="deliver_tbl" class="table table-bordered text-nowrap table-sm text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Request #</th>
                                    <th class="text-center">Date Requested</th>
                                    <th class="text-center">Department </th>
                                    <th class="text-center">Requestor </th>
                                    <th class="text-center">Delivery Address</th>
                                    <th class="text-center">Area </th>
                                    <th class="text-center">Client Name </th>
                                    <th class="text-center">Company Name </th>
                                    <th class="text-center">View Request File </th>
                                    <th class="text-center">Status</th>
                             
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
                        data: "date_created"
                    },
                    {
                        data: "department"
                    },
                    {
                        data: "requestor"
                    },
                    {
                        data: "complete_address"
                    },
                    {
                        data: 'get_area_request',
                        render: function (data, type, row) {
                            return row.get_area_request.area;
                        }
                    },
                    {
                        data: "name_receiver"
                    },
                    {
                        data: "company_name"
                    },
                    {
                        data: "view_file_request",
                    },
                    {
                        data: "req_status",
                    },

                  
                ]
            });


        });

    </script>
@endsection