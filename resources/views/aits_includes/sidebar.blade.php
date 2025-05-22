<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img style="width: 250px; object-fit: cover;"
                src="{{asset('aits_asset/assets/images/brand-logos/vcnew.png')}}" alt="logo" class="desktop-logo">

            <img src="{{asset('aits_asset/assets/images/brand-logos/vc_icon.png')}}" alt="logo" class="toggle-logo">

            <img style="width: 250px; object-fit: cover;"
                src="{{ asset('aits_asset/assets/images/brand-logos/vcnew.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('aits_asset/assets/images/brand-logos/vc_icon.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{route('aits_dashboard')}}"
                        class="side-menu__item {{ Request::is('aits_dashboard') ? 'active' : '' }} ">
                        <i style="width:30px;" class="fa-solid fa-table-columns"></i>

                        <span class="side-menu__label">Dashboard</span>
                        <!-- <span class="badge bg-success ms-auto menu-badge">1</span> -->
                    </a>
                </li>
                <!-- End::slide -->



                @php
                    $romm_request = [
                        'request_room' => Request::is('request_room_view'),
                        'transit_request' => Request::is('transit_request_view'),


                    ];

                    $hospitals = [
                        'hospital_data' => Request::is('hospital_data'),
                        'doctors_data' => Request::is('doctors_data'),
                    ];

                    $admin = [
                        "room_approval_view" => Request::is('room_approval_view'),
                        "aits_car_view" => Request::is('aits_car_view'),
                        "aits_transit_approval_view" => Request::is('aits_transit_approval_view'),
                        "user_manage_view" => Request::is('user_manage_view'),

                    ];

                    $logistics = [
                        "aits_delivery_view" => Request::is('aits_delivery_view'),
                    ];


                @endphp



                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Modules</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub {{in_array(true, $romm_request) ? 'open' : ''}}">
                    <a href="javascript:void(0);"
                        class="side-menu__item {{in_array(true, $romm_request) ? 'active' : ''}}">
                        <i style="width:30px;" class="fa-solid fa-hotel"></i>
                        <span class="side-menu__label">Service Request</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1 ">
                            <a href="javascript:void(0);">Service Request</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('request_room_view') }}"
                                class="side-menu__item {{ Request::is('request_room_view') ? 'active' : '' }}">Room
                                Reservation</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('transit_request_view') }}"
                                class="side-menu__item {{ Request::is('transit_request_view') ? 'active' : '' }}">Shuttle
                                Service Request
                            </a>
                        </li>



                    </ul>
                </li>
                <!-- End::slide -->


                <br>
                <!-- Logistics Request -->
                <li class="slide has-sub {{in_array(true, $logistics) ? 'open' : ''}}">
                    <a href="javascript:void(0);"
                        class="side-menu__item {{in_array(true, $logistics) ? 'active' : ''}}">
                        <i style="width:30px;" class="fa-solid fa-truck-ramp-box"></i>
                        <span class="side-menu__label">Logistics Request</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1 ">
                            <a href="javascript:void(0);">Logistics Request</a>
                        </li>


                        <li class="slide">
                            <a href="{{ route('aits_delivery_view') }}"
                                class="side-menu__item {{ Request::is('aits_delivery_view') ? 'active' : '' }}">
                                Delivery Request</a>
                        </li>








                    </ul>
                </li>


                <br>
                <!-- Admin Slide -->
                <li class="slide has-sub {{in_array(true, $admin) ? 'open' : ''}}">
                    <a href="javascript:void(0);" class="side-menu__item {{in_array(true, $admin) ? 'active' : ''}}">
                        <i style="width:30px;" class="fa-solid fa-user-tie"></i>
                        <span class="side-menu__label">Admin Approval</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1 ">
                            <a href="javascript:void(0);">Service Request</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('room_approval_view') }}"
                                class="side-menu__item {{ Request::is('room_approval_view') ? 'active' : '' }}">Room
                                Reservation</a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('aits_transit_approval_view') }}"
                                class="side-menu__item {{ Request::is('aits_transit_approval_view') ? 'active' : '' }}">
                                Shuttle Service Approval</a>
                        </li>




                        <li class="slide">
                            <a href="{{ route('aits_car_view') }}"
                                class="side-menu__item {{ Request::is('aits_car_view') ? 'active' : '' }}">
                                Car Management</a>
                        </li>


                        <!-- <li class="slide">
                            <a href="{{ route('user_manage_view') }}"
                                class="side-menu__item {{ Request::is('user_manage_view') ? 'active' : '' }}">
                                Users Management</a>
                        </li> -->








                    </ul>
                </li>




                <!-- Start::slide -->
                <!-- <li class="slide has-sub ">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3" />
                            <path
                                d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z" />
                        </svg>
                        <span class="side-menu__label">Elements</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 mega-menu">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">Elements</a>
                        </li>
                        <li class="slide">
                            <a href="alerts.html" class="side-menu__item ">Alerts</a>
                        </li>
                        <li class="slide">
                            <a href="avatars.html" class="side-menu__item">Avatar</a>
                        </li>
                        <li class="slide">
                            <a href="breadcrumb.html" class="side-menu__item">Breadcrumb</a>
                        </li>
                        <li class="slide">
                            <a href="buttons.html" class="side-menu__item">Buttons</a>
                        </li>
                        <li class="slide">
                            <a href="buttongroup.html" class="side-menu__item">Button Group</a>
                        </li>
                        <li class="slide">
                            <a href="badge.html" class="side-menu__item">Badge</a>
                        </li>
                        <li class="slide">
                            <a href="dropdowns.html" class="side-menu__item">Dropdown</a>
                        </li>
                        <li class="slide">
                            <a href="listgroup.html" class="side-menu__item">List Group</a>
                        </li>
                        <li class="slide">
                            <a href="navbar.html" class="side-menu__item">Navbar</a>
                        </li>
                        <li class="slide">
                            <a href="images-figures.html" class="side-menu__item">Images & Figures</a>
                        </li>
                        <li class="slide">
                            <a href="pagination.html" class="side-menu__item">Pagination</a>
                        </li>
                        <li class="slide">
                            <a href="popovers.html" class="side-menu__item">Popovers</a>
                        </li>
                        <li class="slide">
                            <a href="progress.html" class="side-menu__item">Progress</a>
                        </li>
                        <li class="slide">
                            <a href="spinners.html" class="side-menu__item">Spinners</a>
                        </li>
                        <li class="slide">
                            <a href="typography.html" class="side-menu__item">Typography</a>
                        </li>
                        <li class="slide">
                            <a href="tooltips.html" class="side-menu__item">Tooltips</a>
                        </li>
                        <li class="slide">
                            <a href="toasts.html" class="side-menu__item">Toasts</a>
                        </li>
                        <li class="slide">
                            <a href="tags.html" class="side-menu__item">Tags</a>
                        </li>
                        <li class="slide">
                            <a href="navs-tabs.html" class="side-menu__item">Tabs</a>
                        </li>
                        <li class="slide">
                            <a href="scrollspy.html" class="side-menu__item">Scrollspy</a>
                        </li>
                        <li class="slide">
                            <a href="object-fit.html" class="side-menu__item">Object Fit</a>
                        </li>
                    </ul>
                </li> -->
                <!-- End::slide -->

                <!-- Start::slide -->
                <!-- <li class="slide has-sub open">
                    <a href="javascript:void(0);" class="side-menu__item active">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z" />
                        </svg>
                        <span class="side-menu__label">Apps</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">Apps</a>
                        </li>
                        <li class="slide">
                            <a href="cards.html" class="side-menu__item active">Cards</a>
                        </li>
                        <li class="slide">
                            <a href="draggable-cards.html" class="side-menu__item">Draggable Cards</a>
                        </li>
                        <li class="slide">
                            <a href="full-calendar.html" class="side-menu__item">Calendar</a>
                        </li>
                        <li class="slide">
                            <a href="contacts.html" class="side-menu__item">Contacts</a>
                        </li>
                        <li class="slide">
                            <a href="notifications.html" class="side-menu__item">Notifications</a>
                        </li>
                        <li class="slide">
                            <a href="widgets.html" class="side-menu__item">Widgets</a>
                        </li>
                        <li class="slide">
                            <a href="widget-notification.html" class="side-menu__item">Widget-notification</a>
                        </li>
                        <li class="slide">
                            <a href="treeview.html" class="side-menu__item">Treeview</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">File Manager
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="file-manager.html" class="side-menu__item">File-Manager</a>
                                </li>
                                <li class="slide">
                                    <a href="file-manager-list.html" class="side-menu__item">File-Manager-List</a>
                                </li>
                                <li class="slide">
                                    <a href="file-manager-details.html" class="side-menu__item">File-Manager-details</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->

                <!-- Add ka ng open  sa LI sub menu tapos active sa a tag -->
                <!-- End::slide -->

                <li hidden class="slide has-sub open">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z" />
                        </svg>
                        <span class="side-menu__label">Service Request</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1 ">
                            <a href="javascript:void(0);">Service Request</a>
                        </li>
                        <li class="slide">
                            <a href="cards.html" class="side-menu__item active">Cards</a>
                        </li>
                        <li class="slide">
                            <a href="draggable-cards.html" class="side-menu__item">Draggable Cards</a>
                        </li>
                        <li class="slide">
                            <a href="full-calendar.html" class="side-menu__item">Calendar</a>
                        </li>
                        <li class="slide">
                            <a href="contacts.html" class="side-menu__item">Contacts</a>
                        </li>
                        <li class="slide">
                            <a href="notifications.html" class="side-menu__item">Notifications</a>
                        </li>
                        <li class="slide">
                            <a href="widgets.html" class="side-menu__item">Widgets</a>
                        </li>
                        <li class="slide">
                            <a href="widget-notification.html" class="side-menu__item">Widget-notification</a>
                        </li>
                        <li class="slide">
                            <a href="treeview.html" class="side-menu__item">Treeview</a>
                        </li>
                        <li class="slide has-sub open">
                            <a href="javascript:void(0);" class="side-menu__item">File Manager
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="file-manager.html" class="side-menu__item">File-Manager</a>
                                </li>
                                <li class="slide">
                                    <a href="file-manager-list.html" class="side-menu__item">File-Manager-List</a>
                                </li>
                                <li class="slide">
                                    <a href="file-manager-details.html" class="side-menu__item">File-Manager-details</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>






            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>