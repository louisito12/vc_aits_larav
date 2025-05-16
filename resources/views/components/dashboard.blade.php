@extends('apps')


<style>
    .fc-content {
        min-height: 30px;

    }


    .fc-day {
        min-height: 50px;

    }


    .fc-day-top {
        overflow: hidden;

    }

    .fc-event {
        font-size: 12px;
        padding: 5px;
    }
</style>

@section('section')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard </li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Categories <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-archive"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>6</h6>
                                        <span class="text-success small pt-1 fw-bold"></span> <span
                                            class="text-muted small pt-2 ps-1"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>





                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Systems <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ri-computer-line"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>5</h6>
                                        <span class="text-success small pt-1 fw-bold"></span> <span
                                            class="text-muted small pt-2 ps-1"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Users <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>6</h6>
                                        <span class="text-success small pt-1 fw-bold"></span> <span
                                            class="text-muted small pt-2 ps-1"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Files <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-files"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>5</h6>
                                        <span class="text-success small pt-1 fw-bold"></span> <span
                                            class="text-muted small pt-2 ps-1"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div hidden class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <h5 align="center">My Task</h5>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

  
@endsection





<!-- Relationship needs to be constant communication -->