@extends('aits_main_page')



@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Dashboard</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Main</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>

    </div>


    <style>
        .reservations-list {
            max-height: 20px !important;
            /* adjust as needed */

        }

        ,
        .card-body {
            overflow: hidden;
            /* or */
            min-height: 0;
        }

        .el-calendar-table td {
            min-width: 400px;
            min-height: 400px;
        }

        .el-calendar-table .el-calendar-day {
            height: 100%;
            padding: 0;
        }

        .el-calendar-table .el-calendar-day>div {
            height: 104px;
        }
    </style>




    <!-- Page Header Close -->

    @php
        $roles = DB::table('aits_role_access')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->pluck('role_id')
            ->toArray();

    @endphp
    <div class="container-fluid mt-5">
        <style>
            /* body {
                                                        margin-top: 40px;
                                                        background: #eee;
                                                    } */

            .page-todo .tasks {
                /* background: #fff; */
                padding: 0;
                /* border-right: 1px solid #d1d4d7; */
                /* margin: -30px 15px -30px -15px */
            }

            .page-todo .task-list {
                padding: 30px 15px;
                height: 100%;
                scrollbar-width: thin;
            }

            .page-todo .graph {
                height: 100%
            }

            .page-todo .priority.high {
                background: #fffdfd;
                margin-bottom: 1px
            }

            .page-todo .priority.high span {
                background: #f86c6b;
                padding: 2px 10px;
                /* color: #fff; */
                display: inline-block;
                font-size: 12px
            }

            .page-todo .priority.medium {
                /* background: #fff0ab; */
                margin-bottom: 1px
            }

            .page-todo .priority.medium span {
                background: #f8cb00;
                /* padding: 2px 10px; */
                color: #fff;
                display: inline-block;
                font-size: 12px
            }

            .page-todo .priority.low {
                background: #cfedda;
                margin-bottom: 1px
            }

            .page-todo .priority.low span {
                background: #4dbd74;
                padding: 2px 10px;
                /* color: #fff; */
                display: inline-block;
                font-size: 12px
            }

            .page-todo .task {
                /* border-bottom: 1px solid #e4e5e6; */
                margin-bottom: 1px;
                position: relative
            }

            .page-todo .task .desc {
                display: inline-block;
                width: 75%;
                padding: 10px 10px;
                font-size: 12px
            }

            .page-todo .task .desc .title {
                font-size: 18px;
                margin-bottom: 5px
            }

            .page-todo .task .time {
                display: inline-block;
                width: 15%;
                padding: 10px 10px 10px 0;
                font-size: 12px;
                text-align: right;
                position: absolute;
                top: 0;
                right: 0
            }

            .page-todo .task .time .date {
                font-size: 18px;
                margin-bottom: 5px
            }

            .page-todo .task.last {
                border-bottom: 1px solid transparent
            }

            .page-todo .task.high {
                border-left: 2px solid #f86c6b
            }

            .page-todo .task.medium {
                border-left: 2px solid #f8cb00
            }

            .page-todo .task.low {
                border-left: 2px solid #4dbd74
            }

            .page-todo .timeline {
                width: auto;
                height: 100%;
                margin: 20px auto;
                position: relative
            }

            .page-todo .timeline:before {
                position: absolute;
                content: '';
                height: 100%;
                width: 4px;
                background: #d1d4d7;
                left: 50%;
                margin-left: -2px
            }

            .page-todo .timeslot {
                display: inline-block;
                position: relative;
                width: 100%;
                margin: 5px 0
            }

            .page-todo .timeslot .task {
                position: relative;
                width: 44%;
                display: block;
                border: none;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box
            }

            .page-todo .timeslot .task span {
                border: 2px solid #63c2de;
                background: #e1f3f9;
                padding: 5px;
                display: block;
                font-size: 11px
            }

            .page-todo .timeslot .task span span.details {
                font-size: 16px;
                margin-bottom: 10px
            }

            .page-todo .timeslot .task span span.remaining {
                font-size: 14px
            }

            .page-todo .timeslot .task span span {
                border: 0;
                background: 0 0;
                padding: 0
            }

            .page-todo .timeslot .task .arrow {
                position: absolute;
                top: 6px;
                right: 0;
                height: 20px;
                width: 20px;
                border-left: 12px solid #63c2de;
                border-top: 12px solid transparent;
                border-bottom: 12px solid transparent;
                margin-right: -18px
            }

            .page-todo .timeslot .task .arrow:after {
                position: absolute;
                content: '';
                top: -12px;
                right: 3px;
                height: 20px;
                width: 20px;
                border-left: 12px solid #e1f3f9;
                border-top: 12px solid transparent;
                border-bottom: 12px solid transparent
            }

            .page-todo .timeslot .icon {
                position: absolute;
                border: 2px solid #d1d4d7;
                background: #2a2c36;
                -webkit-border-radius: 50em;
                -moz-border-radius: 50em;
                border-radius: 50em;
                height: 30px;
                width: 30px;
                top: 0;
                left: 50%;
                margin-left: -17px;
                color: #fff;
                font-size: 14px;
                line-height: 30px;
                text-align: center;
                text-shadow: none;
                z-index: 2;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box
            }

            .page-todo .timeslot .time {
                background: #d1d4d7;
                position: absolute;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                top: 1px;
                left: 50%;
                padding: 5px 10px 5px 40px;
                z-index: 1;
                margin-top: 1px
            }

            .page-todo .timeslot.alt .task {
                margin-left: 56%;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box
            }

            .page-todo .timeslot.alt .task .arrow {
                position: absolute;
                top: 6px;
                left: 0;
                height: 20px;
                width: 20px;
                border-left: none;
                border-right: 12px solid #63c2de;
                border-top: 12px solid transparent;
                border-bottom: 12px solid transparent;
                margin-left: -18px
            }

            .page-todo .timeslot.alt .task .arrow:after {
                top: -12px;
                left: 3px;
                height: 20px;
                width: 20px;
                border-left: none;
                border-right: 12px solid #e1f3f9;
                border-top: 12px solid transparent;
                border-bottom: 12px solid transparent
            }

            .page-todo .timeslot.alt .time {
                top: 1px;
                left: auto;
                right: 50%;
                padding: 5px 40px 5px 10px
            }

            @media only screen and (min-width:992px) and (max-width:1199px) {
                .page-todo task .desc {
                    display: inline-block;
                    width: 70%;
                    padding: 10px 10px;
                    font-size: 12px
                }

                .page-todo task .desc .title {
                    font-size: 16px;
                    margin-bottom: 5px
                }

                .page-todo task .time {
                    display: inline-block;
                    float: right;
                    width: 20%;
                    padding: 10px 10px;
                    font-size: 12px;
                    text-align: right
                }

                .page-todo task .time .date {
                    font-size: 16px;
                    margin-bottom: 5px
                }
            }

            @media only screen and (min-width:768px) and (max-width:991px) {
                .page-todo .task {
                    margin-bottom: 1px
                }

                .page-todo .task .desc {
                    display: inline-block;
                    width: 65%;
                    padding: 10px 10px;
                    font-size: 10px;
                    margin-right: -20px
                }

                .page-todo .task .desc .title {
                    font-size: 14px;
                    margin-bottom: 5px
                }

                .page-todo .task .time {
                    display: inline-block;
                    float: right;
                    width: 25%;
                    padding: 10px 10px;
                    font-size: 10px;
                    text-align: right
                }

                .page-todo .task .time .date {
                    font-size: 14px;
                    margin-bottom: 5px
                }

                .page-todo .timeslot .task span {
                    padding: 5px;
                    display: block;
                    font-size: 10px
                }

                .page-todo .timeslot .task span span {
                    border: 0;
                    background: 0 0;
                    padding: 0
                }

                .page-todo .timeslot .task span span.details {
                    font-size: 14px;
                    margin-bottom: 0
                }

                .page-todo .timeslot .task span span.remaining {
                    font-size: 12px
                }
            }

            @media only screen and (max-width:767px) {
                .page-todo .tasks {
                    position: relative;
                    margin: 0 !important
                }

                .page-todo .graph {
                    position: relative;
                    margin: 0 !important
                }

                .page-todo .task {
                    margin-bottom: 1px
                }

                .page-todo .task .desc {
                    display: inline-block;
                    width: 65%;
                    padding: 10px 10px;
                    font-size: 10px;
                    margin-right: -20px
                }

                .page-todo .task .desc .title {
                    font-size: 14px;
                    margin-bottom: 5px
                }

                .page-todo .task .time {
                    display: inline-block;
                    float: right;
                    width: 25%;
                    padding: 10px 10px;
                    font-size: 10px;
                    text-align: right
                }

                .page-todo .task .time .date {
                    font-size: 14px;
                    margin-bottom: 5px
                }

                .page-todo .timeslot .task span {
                    padding: 5px;
                    display: block;
                    font-size: 10px
                }

                .page-todo .timeslot .task span span {
                    border: 0;
                    background: 0 0;
                    padding: 0
                }

                .page-todo .timeslot .task span span.details {
                    font-size: 14px;
                    margin-bottom: 0
                }

                .page-todo .timeslot .task span span.remaining {
                    font-size: 12px
                }
            }
        </style>

        <div class="row g-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Admin Information Tracking System</h5>
                        <p class="card-text">
                            The Admin Information Tracking System is a comprehensive platform crafted to simplify and
                            streamline various administrative workflows. This system enables users to submit requests
                            related to room reservations, vehicle services, and logistical assistance through a unified
                            interface. Each request type—be it for scheduling a meeting room, arranging transportation,
                            or coordinating resource delivery—is categorized and tracked efficiently, ensuring that no
                            request is overlooked.
                        </p>
                        <p class="card-text">
                            Central to the system is a dynamic dashboard that provides real-time visibility into all
                            pending, approved, and completed requests. Administrators and support personnel can easily
                            monitor request statuses, assign tasks, generate reports, and ensure timely action,
                            enhancing operational transparency and accountability.
                        </p>
                        <p class="card-text"><strong>User Roles:</strong></p>
                        <p class="card-text">• <strong>Requestor:</strong> Submits and manages service requests such as
                            room bookings, vehicle support, or logistical needs.</p>
                        <p class="card-text">• <strong>Admin:</strong> Oversees incoming requests, assigns tasks,
                            updates statuses, and ensures prompt handling.</p>
                        <p class="card-text">• <strong>Messenger:</strong> Responsible for executing courier-like
                            logistics tasks and delivering messages or items.</p>
                        <p class="card-text">• <strong>Driver:</strong> Handles transportation requests by allocating
                            and operating vehicles as needed.</p>
                        <p class="card-text">• <strong>Super Admin:</strong> Holds full system control—configuring
                            settings, managing users and roles, and auditing all operations.</p>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid my-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid page-todo bootstrap snippets bootdeys">
                                <div class="tasks">
                                    <h3>Room Reservations</h3>
                                    <div id="room_reserve_html" style="overflow-y:auto; max-height : 400px;"
                                        class="task-list">


                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>



        @if (in_array(2, $roles) || in_array(3, $roles))
            <div class="row mx-auto">
                <!-- Pending Requests -->
                <div class="col-md-4">
                    <div class="card border-warning shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-warning mb-4">
                                <i class="fa-solid fa-hourglass-half me-2"></i>Pending Requests
                            </h5>
                            <div class="list-group">
                                <a data-id="1" data-name="room_request"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_room_dash">
                                    Room Reservations
                                    <span class="badge bg-warning text-dark room_reserve1">0</span>
                                </a>

                                <a data-name="transit_request" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_transit">
                                    Shuttle Requests
                                    <span class="badge bg-warning text-dark transit_request_text1">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="1" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Delivery
                                    <span class="badge bg-warning text-dark delivery_logistic1">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="2" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Collection
                                    <span class="badge bg-warning text-dark collection_logistic1">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="3" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Pick Up
                                    <span class="badge bg-warning text-dark pickup_logistic1">0</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Requests -->
                <div class="col-md-4">
                    <div class="card border-primary shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-4">
                                <i class="fa-solid fa-pen-to-square me-2"></i>APPROVED REQUEST TODAY
                            </h5>
                            <div class="list-group">
                                <a data-id="2" data-name="room_request"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_room_dash">
                                    Room Reservations
                                    <span class="badge bg-primary room_reserve2">0</span>
                                </a>
                                <a data-name="transit_request" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_transit">
                                    Shuttle Requests
                                    <span class="badge bg-primary transit_request_text2">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="1" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Delivery
                                    <span class="badge bg-primary delivery_logistic2">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="2" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Collection
                                    <span class="badge bg-primary collection_logistic2">0</span>
                                </a>
                                <a data-name="for_delivery" data-procedure="3" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Pick Up
                                    <span class="badge bg-primary pickup_logistic2">0</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved Requests -->
                <div class="col-md-4">
                    <div class="card border-success shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success mb-4">
                                <i class="fa-solid fa-circle-check me-2"></i>Completed Requests
                            </h5>
                            <div class="list-group">
                                <a data-id="3" data-name="room_request"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_room_dash">
                                    Room Reservations
                                    <span class="badge bg-success  room_reserve3">0</span>
                                </a>

                                <a data-name="transit_request" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_transit">
                                    Shuttle Requests
                                    <span class="badge bg-success  transit_request_text3">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="1" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Delivery
                                    <span class="badge bg-success  delivery_logistic3">0</span>
                                </a>



                                <a data-name="for_delivery" data-procedure="2" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Collection
                                    <span class="badge bg-success collection_logistic3">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="3" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Pick Up
                                    <span class="badge bg-success pickup_logistic3">0</span>
                                </a>


                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cancelled Request --}}
                <!-- Approved Requests -->
                <div hidden class="col-md-3">
                    <div class="card border-danger shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-danger mb-4">
                                <i class="fa-solid fa-trash"></i> Cancelled Requests

                            </h5>
                            <div class="list-group">
                                <a data-id="4" data-name="room_request"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_room_dash">
                                    Room Reservations
                                    <span class="badge bg-danger  room_reserve4">0</span>
                                </a>

                                <a data-name="transit_request" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_transit">
                                    Shuttle Requests
                                    <span class="badge bg-danger  transit_request_text4">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="1" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Delivery
                                    <span class="badge bg-danger  delivery_logistic4">0</span>
                                </a>



                                <a data-name="for_delivery" data-procedure="2" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Collection
                                    <span class="badge bg-danger collection_logistic4">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="3" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics">
                                    For Pick Up
                                    <span class="badge bg-danger pickup_logistic4">0</span>
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endif


        @if (in_array(4, haystack: $roles))
            <div class="row g-3">
                <!-- Pending Requests -->
                <div class="col-md-4">
                    <div class="card border-warning shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-warning mb-4">
                                <i class="fa-solid fa-hourglass-half me-2"></i>Pending Requests Messenger
                            </h5>
                            <div class="list-group">


                                <a data-name="for_delivery" data-procedure="1" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Delivery
                                    <span class="badge bg-warning text-dark delivery_mess_logistic1">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="2" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Collection
                                    <span class="badge bg-warning text-dark collection_mess_logistic1">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="3" data-id="1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Pick Up
                                    <span class="badge bg-warning text-dark pickup_mess_logistic1">0</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Requests -->
                <div class="col-md-4">
                    <div class="card border-primary shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-4">
                                <i class="fa-solid fa-pen-to-square me-2"></i>ON GOING REQUEST Messenger
                            </h5>
                            <div class="list-group">
                                <a data-name="for_delivery" data-procedure="1" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Delivery
                                    <span class="badge bg-primary delivery_mess_logistic2">0</span>
                                </a>
                                <a data-name="for_delivery" data-procedure="2" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Collection
                                    <span class="badge bg-primary collection_mess_logistic2">0</span>
                                </a>
                                <a data-name="for_delivery" data-procedure="3" data-id="2"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Pick Up
                                    <span class="badge bg-primary pickup_mess_logistic2">0</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved Requests -->
                <div class="col-md-4">
                    <div class="card border-success shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success mb-4">
                                <i class="fa-solid fa-circle-check me-2"></i>Completed Requests Messenger
                            </h5>
                            <div class="list-group">
                                <a data-name="for_delivery" data-procedure="1" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Delivery
                                    <span class="badge bg-success  delivery_mess_logistic3">0</span>
                                </a>


                                <a data-name="for_delivery" data-procedure="2" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Collection
                                    <span class="badge bg-success collection_mess_logistic3">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="3" data-id="3"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Pick Up
                                    <span class="badge bg-success pickup_mess_logistic3">0</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>


                <!--  Cancelled Request-->

                <div hidden class="col-md-3">
                    <div class="card border-danger shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-danger mb-4">
                                <i class="fa-solid fa-trash"></i> Cancelled Requests Messenger
                            </h5>
                            <div class="list-group">
                                <a data-name="for_delivery" data-procedure="1" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Delivery
                                    <span class="badge bg-danger  delivery_mess_logistic4">0</span>
                                </a>


                                <a data-name="for_delivery" data-procedure="2" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Collection
                                    <span class="badge bg-danger collection_mess_logistic4">0</span>
                                </a>

                                <a data-name="for_delivery" data-procedure="3" data-id="4"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn_logistics_mess">
                                    For Pick Up
                                    <span class="badge bg-danger pickup_mess_logistic4">0</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endif
    </div>




    <div class="modal fade" id="room_request_modal" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Room Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="room_request_tbl"
                                    class="table table-bordered text-nowrap table-sm text-center w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Request #</th>
                                            <th class="text-center">Request Room</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Date From</th>
                                            <th class="text-center">Date To</th>
                                            <th class="text-center">Event/Purpose</th>
                                            <th class="text-center">Date Requested</th>
                                            <th class="text-center">Request Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="transit_request_modal" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="">Transit Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tbl_transit" class="table table-bordered table-sm text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Request #</th>
                                            <th>Date Requested</th>
                                            <th>Departure Date</th>
                                            <th>Appointment Date</th>
                                            <th>Pick Up Date</th>
                                            <th>Distanation</th>
                                            <th>Requested By</th>
                                            <th>Type</th>
                                            <th>OB File</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="logistics_modal" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="logistic_header">Delivery Request
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="deliver_tbl"
                                    class="table table-bordered text-nowrap table-sm w-100 text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Request #</th>
                                            <th class="text-center">Date Requested</th>
                                            <th class="text-center">Department </th>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="intro_modal" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="logistic_header">Welcome to AITS System
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">

                            <img src="{{ asset('new_assets/assets/img/aits_intro.jpg') }}" class="w-100" />

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                </div>
            </div>
        </div>
    </div>







    {{-- <div class="col-lg-4">
      <img
        src="https://mdbcdn.b-cdn.net/img/Photos/Thumbnails/Slides/2.webp"
        data-mdb-img="https://mdbcdn.b-cdn.net/img/Photos/Slides/2.webp"
        alt="Winter Landscape"
        class="w-100"
      />
    </div> --}}
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // $('#intro_modal').modal('show');

            function columns_data(type_request) {
                if (type_request == "room_request") {
                    return [{
                            data: "request_no"
                        },
                        {
                            data: "room"
                        },

                        {
                            data: "department"
                        },
                        {
                            data: "date_from"
                        },
                        {
                            data: "date_to"
                        },
                        {
                            data: "event"
                        },
                        {
                            data: "date_created"
                        },
                        {
                            data: "status"
                        },

                    ]

                }



                if (type_request == "transit_request") {
                    return [{
                            data: "request_no"
                        },
                        {
                            data: "date_created"
                        },
                        {
                            data: "departure_date"
                        },
                        {
                            data: "appointment_date"
                        },
                        {
                            data: "pick_up_date"
                        },
                        {
                            data: "destination"
                        },
                        {
                            data: "reuqeusted_by"
                        },
                        {
                            data: "type"
                        },
                        {
                            data: "action_file",
                        },
                        {
                            data: "status_html"
                        },

                    ];
                }


                if (type_request == "logistic_request") {
                    return [{
                            data: "request_no"
                        },

                        {
                            data: "date_created"
                        },
                        {
                            data: "department"
                        },
                        {
                            data: "complete_address"
                        },
                        {
                            data: 'get_area_request',
                            render: function(data, type, row) {
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
                }
            }


         

            @if (in_array(2, $roles) || in_array(3, $roles))


                // room_reserve_html
                $.ajax({
                    url: "{{ route('room_reserve_html', 1) }}",
                    type: "GET",
                    success: function(e) {
                        // console.log(e);
                        $('#room_reserve_html').html(e);
                    }
                });

                function counters() {
                    $.ajax({
                        url: "{{ route('aits_dashboard_counts') }}",
                        type: "GET",
                        success: function(e) {
                            if (e['isValid'] == false) {
                                alertify.set('notifier', 'position', 'top-right');
                                alertify.set('notifier', 'delay', 5);
                                alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                                return;
                            }
                            const {
                                pending_count,
                                ongoing_count,
                                completed_count,
                                deleted_counts
                            } = e.room_request;
                            $('.room_reserve1').text(pending_count ?? 0);
                            $('.room_reserve2').text(ongoing_count ?? 0);
                            $('.room_reserve3').text(completed_count ?? 0);
                            $('.room_reserve4').text(deleted_counts ?? 0);




                            $('.transit_request_text1').text(e['vehicle_request']['pending_count'] ??
                                0);
                            $('.transit_request_text2').text(e['vehicle_request']['ongoing_count'] ??
                                0);
                            $('.transit_request_text3').text(e['vehicle_request']['completed_count'] ??
                                0);
                            $('.transit_request_text4').text(e['vehicle_request'][
                                    'vehicle_cancelled'
                                ] ??
                                0);



                            // $('.delivery_logistic1').text(0);
                            // $('delivery_logistic2').text(0);
                            // $('delivery_logistic3').text(0);

                            // $('.collection_logistic1').text(0);
                            // $('.collection_logistic2').text(0);
                            // $('.collection_logisti3').text(0);


                            // $('.pickup_logistic1').text(0);
                            // $('.pickup_logistic2').text(0);
                            // $('.pickup_logistic3').text(0);


                            var logisticsRequests = e['logistics_request'];
                            var searchStatus = "For Delivery";
                            var index = -1;
                            var collection_params = "For Collection"
                            var collection_index = -1;
                            var pick_up_params = "For Pick Up";
                            var pick_up_index = -1;

                            $.each(logisticsRequests, function(i, obj) {
                                if (obj.procedure_status == searchStatus) {
                                    index = i;
                                }

                                if (obj.procedure_status == collection_params) {
                                    collection_index = i;
                                }

                                if (obj.procedure_status == pick_up_params) {
                                    pick_up_index = i;
                                }

                            });


                            if (index != -1) {
                                $('.delivery_logistic1').text(logisticsRequests[index][
                                    'pending_counts'
                                ]);
                                $('.delivery_logistic2').text(logisticsRequests[index]['On_going']);
                                $('.delivery_logistic3').text(logisticsRequests[index]['Approved']);
                                $('.delivery_logistic4').text(logisticsRequests[index]['cancel_req']);


                            }


                            if (collection_index != -1) {
                                $('.collection_logistic1').text(logisticsRequests[collection_index][
                                    'pending_counts'
                                ]);
                                $('.collection_logistic2').text(logisticsRequests[collection_index][
                                    'On_going'
                                ]);
                                $('.collection_logistic3').text(logisticsRequests[collection_index][
                                    'Approved'
                                ]);
                                $('.collection_logistic4').text(logisticsRequests[collection_index][
                                    'cancel_req'
                                ]);
                            }


                            if (pick_up_index != -1) {
                                $('.pickup_logistic1').text(logisticsRequests[pick_up_index][
                                    'pending_counts'
                                ]);
                                $('.pickup_logistic2').text(logisticsRequests[pick_up_index][
                                    'On_going'
                                ]);
                                $('.pickup_logistic3').text(logisticsRequests[pick_up_index][
                                    'Approved'
                                ]);

                                $('.pickup_logistic4').text(logisticsRequests[pick_up_index][
                                    'cancel_req'
                                ]);

                            }


                        }
                    });
                }

                counters();

                setInterval(function() {
                    counters();
                }, 5 * 60 * 1000);
            @elseif (in_array(4, $roles))

                function messenger_counter() {
                    $.ajax({
                        url: "{{ route('aits_dashboard_counts_messenger') }}",
                        type: "GET",
                        success: function(e) {
                            if (e['isValid'] == false) {
                                alertify.set('notifier', 'position', 'top-right');
                                alertify.set('notifier', 'delay', 5);
                                alertify.error('<span style="color: white;">' + e['msg'] + '</span>');
                                return;
                            }
                            var logisticsRequests = e['logistics_request_messenger'];
                            var for_delivery = "For Delivery";
                            var index_messenger = -1;
                            var for_collection = "For Collection"
                            var collection_index_messenger = -1;
                            var for_pick_up = "For Pick Up";
                            var pick_up_index_messenger = -1;

                            $.each(logisticsRequests, function(i, obj) {
                                if (obj.procedure_status == for_delivery) {
                                    index_messenger = i;
                                }

                                if (obj.procedure_status == for_collection) {
                                    collection_index_messenger = i;
                                }

                                if (obj.procedure_status == for_pick_up) {
                                    pick_up_index_messenger = i;
                                }

                            });



                            if (index_messenger != -1) {
                                $('.delivery_mess_logistic1').text(logisticsRequests[index_messenger][
                                    'pending_counts'
                                ]);
                                $('.delivery_mess_logistic2').text(logisticsRequests[index_messenger][
                                    'On_going'
                                ]);
                                $('.delivery_mess_logistic3').text(logisticsRequests[index_messenger][
                                    'Approved'
                                ]);

                            }


                            if (collection_index_messenger != -1) {
                                $('.collection_mess_logistic1').text(logisticsRequests[
                                    collection_index_messenger]['pending_counts']);
                                $('.collection_mess_logistic2').text(logisticsRequests[
                                    collection_index_messenger]['On_going']);
                                $('.collection_mess_logistic3').text(logisticsRequests[
                                    collection_index_messenger]['Approved']);
                            }


                            if (pick_up_index_messenger != -1) {
                                $('.pickup_mess_logistic1').text(logisticsRequests[
                                    pick_up_index_messenger]['pending_counts']);
                                $('.pickup_mess_logistic2').text(logisticsRequests[
                                    pick_up_index_messenger]['On_going']);
                                $('.pickup_mess_logistic3').text(logisticsRequests[
                                    pick_up_index_messenger]['Approved']);

                                $('.pickup_mess_logistic4').text(logisticsRequests[
                                    pick_up_index_messenger]['cancelled']);

                            }


                        }
                    });
                }
                messenger_counter()
                setInterval(function() {
                    messenger_counter()
                }, 5 * 60 * 1000);
            @endif

            $('.btn_room_dash').click(function() {
                $('#room_request_modal').modal('show');
                $('#room_request_tbl').DataTable({
                    destroy: true,
                    ajax: {
                        url: "room_request_dash/" + $(this).data('id'),
                    },
                    columns: columns_data($(this).data('name')),
                })

            });

            $('.btn_transit').click(function() {
                $('#transit_request_modal').modal('show');
                $('#tbl_transit').DataTable({
                    destroy: true,
                    ajax: {
                        url: "transit_request_dash/" + $(this).data('id'),
                    },
                    columns: columns_data($(this).data('name')),
                })

            });


            $('.btn_logistics').click(function() {
                $('#logistics_modal').modal('show');
                const header_text = $(this).data('procedure') == 1 ?
                    'For Delivery Request' :
                    $(this).data('procedure') == 2 ?
                    'For Collection Request' :
                    $(this).data('procedure') == 3 ?
                    'For Pick Up Request' :
                    '';


                $('#logistic_header').text(header_text);
                $('#deliver_tbl').DataTable({
                    destroy: true,
                    ajax: {
                        url: "aits_dashboard_logistics/" + $(this).data('id') + '/' + $(this).data(
                            'procedure'),
                    },
                    columns: columns_data('logistic_request'),
                });
            });



            $('.btn_logistics_mess').click(function() {
                $('#logistics_modal').modal('show');
                const header_text = $(this).data('procedure') == 1 ?
                    'For Delivery Request' :
                    $(this).data('procedure') == 2 ?
                    'For Collection Request' :
                    $(this).data('procedure') == 3 ?
                    'For Pick Up Request' :
                    '';

                $('#logistic_header').text(header_text);
                $('#deliver_tbl').DataTable({
                    destroy: true,
                    ajax: {
                        url: "aits_dashboard_logistics_mess/" + $(this).data('id') + '/' + $(this)
                            .data('procedure'),
                    },
                    columns: columns_data('logistic_request'),
                });
            });

            display_events();

            function display_events() {
                // var events = new Array();
                const events = [{
                        event_id: 1,
                        title: "sdfsd",
                        start: "2025-04-14",
                        end: "2025-04-16",
                        color: "#FFA500"
                    },
                    {
                        event_id: 2,
                        title: "TEST EDIT",
                        start: "2025-04-02",
                        end: "2025-04-03",
                        color: "#FF0000"
                    }
                ];

                $.ajax({
                    url: '{{ route('pms_alert') }}',
                    dataType: 'json',
                    success: function(response) {
                        var result = response.data;
                        // $.each(result, function(i, item) {
                        //     var startDate = moment(item.start).format('YYYY-MM-DD') +
                        //         'T00:00:00';
                        //     var endDate = moment(item.end).format('YYYY-MM-DD') + 'T23:59:59';

                        //     let textColor = (hexToRgb(item.color).r * 0.299 +
                        //             hexToRgb(item.color).g * 0.587 +
                        //             hexToRgb(item.color).b * 0.114) > 186 ? '#000000' :
                        //         '#FFFFFF';

                        //     function hexToRgb(hex) {
                        //         let r = parseInt(hex.slice(1, 3), 16);
                        //         let g = parseInt(hex.slice(3, 5), 16);
                        //         let b = parseInt(hex.slice(5, 7), 16);
                        //         return {
                        //             r,
                        //             g,
                        //             b
                        //         };
                        //     }
                        //     events.push({
                        //         event_id: item.event_id,
                        //         title: item.title,
                        //         start: startDate,
                        //         end: endDate,
                        //         color: item.color,
                        //         textColor: textColor,
                        //     });
                        // });

                        if ($('#calendar').fullCalendar) {
                            $('#calendar').fullCalendar('destroy');
                        }
                        $('#calendar').fullCalendar({
                            defaultView: 'month',
                            timeZone: 'local',
                            editable: true,
                            selectable: true,
                            selectHelper: true,
                            select: function(start, end) {
                                $('#event_start_date').val(moment(start).format(
                                    'YYYY-MM-DD'));
                                $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                                alert(moment(start).format('YYYY-MM-DD'));
                                // $('#event_entry_modal').modal('show');
                                task_item_data()

                            },
                            events: events,

                            eventRender: function(event, element, view) {
                                var eventName = event.title;
                                element.find('.fc-time').html('<center>' + eventName +
                                    '</center>');
                                element.find('.fc-title').text('');
                                element.bind('click', function() {
                                    // alert('Event: ' + eventName + '  ==>' + event.event_id + '\nStart: ' + moment(event.start).format('YYYY-MM-DD HH:mm:ss') + '\nEnd: ' + moment(event.end).format('YYYY-MM-DD HH:mm:ss'));
                                    $('#edit_task_modal').modal('show');
                                    get_task_data(event.event_id)


                                });
                            },
                            eventTimeFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                meridiem: false
                            },


                            eventDrop: function(event, delta, revertFunc) {
                                console.log("Event ID:", event.event_id);
                                console.log("New Start:", moment(event.start).format(
                                    'YYYY-MM-DD HH:mm:ss'));
                                if (event.end) {
                                    console.log("New End:", moment(event.end).format(
                                        'YYYY-MM-DD HH:mm:ss'));
                                } else {
                                    console.log("No end date set");
                                }

                            },
                        });
                    },

                });
            }



        });
    </script>
@endsection
