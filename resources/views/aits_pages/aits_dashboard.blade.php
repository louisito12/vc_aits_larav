@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Dashboard</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Hi
                            {{ Auth::user()->username }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard </li>
                </ol>
            </nav>
        </div>




    </div>


    <!-- Page Header Close -->

    <!-- Total Requests Section -->
    <div class="row">
        <div class="container mt-4">
            <div class="row">
                <!-- Total Requests Section -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fa-solid fa-pen-to-square"></i> Total Requests</h5>
                            <ol class="list-group list-group-numbered">
                                <a href="{{ route($links['room_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Room Reservation
                                    <span class="badge bg-primary rounded-pill">
                                        {{ (int) $room_approve_counts + (int) $room_pending_counts }}
                                    </span>
                                </a>

                                <a href="{{ route($links['logistics_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Logistics Request
                                    <span class="badge bg-primary rounded-pill">
                                        {{ (int) $logistics_pending_counts + (int) $logistics_approve_counts }}
                                    </span>
                                </a>

                                <a href="{{ route($links['shuttle_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Shuttle Request
                                    <span class="badge bg-primary rounded-pill">
                                        {{ (int) $shuttle_approve_counts + (int) $shuttle_pending_counts  }}
                                    </span>
                                </a>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Section -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fa-solid fa-hourglass-end"></i> Pending Requests</h5>
                            <ol class="list-group list-group-numbered">
                                <a href="{{route($links['room_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Room Reservation
                                    <span class="badge bg-warning text-dark rounded-pill">
                                        {{ $room_pending_counts }}
                                    </span>
                                </a>


                                <a href="{{ route($links['logistics_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Logistics Request
                                    <span class="badge bg-warning text-dark rounded-pill">
                                        {{(int) $logistics_pending_counts  }}
                                    </span>
                                </a>



                                <a href="{{ route($links['shuttle_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Shuttle Request
                                    <span class="badge bg-warning text-dark rounded-pill">
                                        {{ (int) $shuttle_pending_counts  }}
                                    </span>
                                </a>

                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Approved Requests Section -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-check-circle"></i> Approved Requests</h5>
                            <ol class="list-group list-group-numbered">
                                <a href="{{route($links['room_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Room Reservation
                                    <span class="badge bg-success text-dark rounded-pill">
                                        {{(int) $room_approve_counts }}
                                    </span>
                                </a>

                                <a href="{{ route($links['logistics_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Logistics Request
                                    <span class="badge bg-success text-dark rounded-pill">
                                        {{ (int) $logistics_approve_counts }}
                                    </span>
                                </a>

                                <a href="{{ route($links['shuttle_request']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Shuttle Request
                                    <span class="badge bg-success text-dark rounded-pill">
                                        {{ (int) $shuttle_approve_counts }}
                                    </span>
                                </a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')

@endsection