@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Profile</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
        <!-- <div   class="d-flex my-xl-auto right-content align-items-center">
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i
                            class="mdi mdi-filter-variant"></i></button>
                </div>
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon me-2"><i
                            class="mdi mdi-star"></i></button>
                </div>
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-warning  btn-icon me-2"><i
                            class="mdi mdi-refresh"></i></button>
                </div>
                <div  class="mb-xl-0">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuDate"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            14 Aug 2019
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                            <li><a class="dropdown-item" href="javascript:void(0);">2015</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2016</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2017</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2018</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->

    </div>


    <!-- Page Header Close -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Basic Datatable
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbl_data" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="spec_input w-25">Doctor Name</th>
                                    <th class="spec_input w-25">Doctor Code</th>
                                    <th class="spec_input w-25">Contact#</th>
                                    <th class="spec_input w-25">Specialization</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $('#tbl_data').DataTable(
                {
                    serverSide: true,
                    processing: true,
                    paging: true,
                    language: {
                        searchPlaceholder: 'Search...',
                        sSearch: '',
                    },
                    ajax: {
                        url: "{{ route('get_doctors_data') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },


                    },
                    columns: [
                        {
                            data: "hospName",
                            title: 'Doctor Name',
                            "createdCell": function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'max-width': '100px',
                                    'white-space': 'normal',
                                    'word-wrap': 'break-word'
                                }).addClass('spec_input');;
                            },
                        },
                        {
                            data: "hospCode",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                $(td).addClass('spec_input')
                            }
                        },
                        {
                            data: "hospContactno",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'max-width': '200px',
                                    'white-space': 'normal',
                                    'word-wrap': 'break-word'

                                }).addClass('spec_input');;
                            },

                        },
                        {
                            data: "sp_name",
                            "createdCell": function (td, cellData, rowData, row, col) {
                                $(td).addClass('spec_input')
                            }
                        }
                    ],
                    "drawCallback": function (oSettings) {
                        let pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                        pagination.toggle(this.api().page.info().pages > 1);
                        let pagedetails = $(this).closest('.dataTables_wrapper').find('.dataTables_info');
                        pagedetails.toggle(this.api().page.info().pages > 0);
                    }
                }
            );



        })
    </script>

@endsection