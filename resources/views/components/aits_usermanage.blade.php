@extends('apps')


@section('section')
    <div class="pagetitle">
        <h1>Room Reservations Requests</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data</li>
            </ol>

        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <h5 class="card-title">User Management</h5>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-2">
                                <br>
                                <button id="btn_add" class="btn btn-success spec_input">Add User</button>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="tbl_user" class="table table-bordered  table-striped spec_input">
                                        <thead>

                                            <tr>
                                                <th scope="col">FullName</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Position</th>
                                                <th scope="col">Username</th>
                                                <th scope="col" style="min-width: 100px">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection



@section('script')
    <script>
        $(document).ready(function () {



            renderDataTable({
                selector: `#itemsTable`,
                apiUrl: '../../modules/items/items.php?action=list',
                title: 'Items Table',
                serverSide: true,
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'description' },
                    { data: 'brand' },
                    { data: 'model_number' },
                    { data: 'item_type' },
                    { data: 'unit' },
                    { data: 'actions' }
                ]
            });



            // Reusable DataTable initializer
            function renderDataTable(options) {
                const {
                    selector,
                    apiUrl,
                    title = '',
                    serverSide = false,
                    columns = null // Optional: custom columns
                } = options;

                // Destroy existing DataTable if exists
                if ($.fn.DataTable.isDataTable(selector)) {
                    $(selector).DataTable().destroy();
                    $(selector).empty(); // Remove old table head/body
                }

                // Default columns if not provided
                let dtColumns = columns;
                if (!dtColumns) {
                    // Try to auto-detect columns from thead
                    dtColumns = [];
                    $(`${selector} thead th`).each(function () {
                        const colName = $(this).text().toLowerCase().replace(/\s+/g, '_');
                        dtColumns.push({ data: colName });
                    });
                }

                // Remove custom render for 'actions' column; let server provide HTML
                dtColumns = dtColumns.map(col => {
                    if (col.data === 'actions') {
                        return {
                            ...col,
                            orderable: false,
                            searchable: false
                            // No render function; server provides HTML
                        };
                    }
                    return col;
                });
                let eltb = $(selector)[0];
                // Build DataTable
                window.table = $(selector).DataTable({
                    colReorder: true,
                    processing: true,
                    serverSide: serverSide,
                    ajax: {
                        url: apiUrl,
                        type: 'POST'
                    },
                    columns: dtColumns,
                    responsive: true,
                    dom: 'lBfrtip',
                    scrollX: true,
                    scrollY: 'calc(95vh / 2.5)',
                    buttons: [
                        {
                            extend: 'collection',
                            text: '<i class="bi bi-download"></i> Export',
                            className: 'btn btn-sm btn-primary mt-1',
                            autoClose: true,
                            buttons: [
                                {
                                    extend: 'csv',
                                    className: 'dropdown-item',
                                    title: title || '',
                                    text: 'CSV (Current Page)',
                                    exportOptions: {
                                        columns: dtColumns
                                            .map((col, idx) => col.data !== 'actions' ? idx : null)
                                            .filter(idx => idx !== null),
                                        modifier: { page: 'current' }
                                    }
                                },
                                {
                                    extend: 'csv',
                                    className: 'dropdown-item',
                                    title: title || '',
                                    text: 'CSV (All Data)',
                                    action: function () {
                                        exportAllDataAsCSV(apiUrl + '&export=csv', title);
                                    },
                                    exportOptions: {
                                        columns: dtColumns
                                            .map((col, idx) => col.data !== 'actions' ? idx : null)
                                            .filter(idx => idx !== null),
                                        modifier: { page: 'all' },


                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'dropdown-item',
                                    title: title || '',
                                    text: 'PDF (Current Page)',
                                    exportOptions: {
                                        columns: dtColumns
                                            .map((col, idx) => col.data !== 'actions' ? idx : null)
                                            .filter(idx => idx !== null),
                                        modifier: { page: 'current' }
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'dropdown-item',
                                    title: title || '',
                                    text: 'PDF (All Data)',
                                    action: function () {
                                        exportAllDataAsPDF(apiUrl + '&export=csv', title)
                                    },
                                    exportOptions: {
                                        columns: dtColumns
                                            .map((col, idx) => col.data !== 'actions' ? idx : null)
                                            .filter(idx => idx !== null),
                                        modifier: { page: 'all' }
                                    }
                                },
                                {
                                    extend: 'print',
                                    className: 'dropdown-item',
                                    text: 'Print',
                                    title: title || '',
                                    exportOptions: {
                                        columns: dtColumns
                                            .map((col, idx) => col.data !== 'actions' ? idx : null)
                                            .filter(idx => idx !== null)
                                    }
                                }
                            ]
                        }
                    ],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search...",
                        lengthMenu: "_MENU_",
                        info: "_START_ - _END_ of _TOTAL_",
                        paginate: {
                            previous: "<",
                            next: ">"
                        }
                    },
                    colResize: {
                        realtime: false
                    },

                    // Optional: Add title above table
                    initComplete: function () {
                        /* dt-buttons btn-group */
                        const $search = $(this.api().table().container()).find('.dt-search');
                        const $buttons = $(this.api().table().container()).find('.dt-buttons');
                        const $dtinfo = $(this.api().table().container()).find('.dt-info');
                        const $dtlength = $(this.api().table().container()).find('.dt-length');
                        /*   $buttons.append(`<span class="input-group-text datatable-title float-start fw-bold ms-2">${title}</span>`); */
                        $buttons.addClass('btn-group-sm mb-1');
                        $search.addClass('mb-2');
                        /*   $dtinfo.addClass('text-light');
                          $dtlength.addClass('text-light'); */
                        // Custom toolbar row
                        const $entriesLabel = $dtlength.find('label').text('Entries');
                        const $entriesDropdown = $dtlength.find('select');
                        const $searchInput = $search.find('input');
                        const $row = $('<div class="d-flex flex-column flex-md-row align-items-center mb-2"></div>');
                        $row.append($buttons);
                        $row.append($('<div class="ms-2 me-3"></div>').append($dtlength));
                        $row.append($('<div class="me-2"></div>').append($entriesLabel));
                        $row.append($('<div class="flex-grow-1"></div>').append($searchInput));
                        $search.empty().append($row);
                        /*   if (title) {
                              if (!$(selector).prev('.datatable-title').length) {
                                  $(selector).before(`<div class="datatable-title h5 mb-2">${title}</div>`);
                              }
                          } */
                        // Enable column resizing if plugin is loaded
                        /*   if (typeof $(selector).colResizable === 'function') {

                              setTimeout(function () {
                                  console.log(selector);
                                  $(eltb).colResizable({
                                      liveDrag: true,
                                      resizeMode: 'fit'
                                  });
                                  console.log(eltb);
                                  console.log('working');
                              }, 500);
                          } */
                    }
                });
                return window.table;
            }
        })
    </script>
@endsection

<!-- Modals -->