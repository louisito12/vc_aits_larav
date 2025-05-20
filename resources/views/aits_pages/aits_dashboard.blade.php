@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Dashboard</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Hi
                            {{ Auth::user()->username }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>




    </div>


    <!-- Page Header Close -->


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-primary-gradient">
                        <div class="px-3 pt-3  pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">TODAY ORDERS</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="fs-20 fw-bold mb-1 text-fixed-white">$5,74.12</h4>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="compositeline"></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-danger-gradient">
                        <div class="px-3 pt-3  pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">TODAY EARNINGS</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="fs-20 fw-bold mb-1 text-fixed-white">$1,230.17</h4>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="compositeline2"></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-success-gradient">
                        <div class="px-3 pt-3  pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">TOTAL EARNINGS</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="fs-20 fw-bold mb-1 text-fixed-white">$7,125.70</h4>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="compositeline3"></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-warning-gradient">
                        <div class="px-3 pt-3  pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">PRODUCT SOLD</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="fs-20 fw-bold mb-1 text-fixed-white">$4,820.50</h4>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="compositeline4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection


@section('scripts')


@endsection