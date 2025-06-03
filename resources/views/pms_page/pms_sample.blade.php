@extends('aits_main_page')



@section('content')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Roles</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
        </div>

    </div>


    <!-- Page Header Close -->


    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center p-0">
                    <div class="card-title m-1 p-3">Roles</div>
                    <button id="add_request_btn" class="btn btn-success m-3">Add Roles</button>
                </div>

                <div class="card-body">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#taskNotificationModal">
                        Show Tasks
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modals -->


    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="taskNotificationModal" tabindex="-1" aria-labelledby="taskNotificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-warning text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskNotificationModalLabel">Action Required</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><i class="bi bi-exclamation-triangle-fill text-dark"></i> Please complete the following tasks:</p>
                    <ul>
                        <li><input class="form-check-input" type="checkbox" id="task1"> Review the latest project update.
                        </li>
                        <li><input class="form-check-input" type="checkbox" id="task2"> Submit your timesheet for last week.
                        </li>
                        <li><input class="form-check-input" type="checkbox" id="task3"> Attend the team meeting at 3 PM.
                        </li>
                    </ul>
                    <!-- <p>Ensure all tasks are completed before the end of the day.</p>
                      -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="markAllAsDone()">Mark All as Done</button>
                </div>
            </div>
        </div>
    </div>








@endsection

@section('scripts')
    <script>
        function markAllAsDone() {
            document.getElementById('task1').checked = true;
            document.getElementById('task2').checked = true;
            document.getElementById('task3').checked = true;
        }
    </script>
@endsection