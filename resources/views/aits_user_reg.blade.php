<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.headers')

</head>

<body>
    <style>
        .input-container {
            position: relative;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
        }

        .spec_input {
            font-size: 12px;
            padding: 2px;
        }


        .tab-pane {
            padding: 10px;
        }

        .tab-content {
            width: 100%;
        }

        .form-control,
        .form-select {
            max-width: 100%;
        }

        .form-group {
            width: 100%;
        }
    </style>

    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ route('login') }}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('new_assets/assets/img/vc_red2.png') }}" alt="">
                                    <span class="d-none d-lg-block">VC-AITS </span>
                                </a>
                            </div>


                            <div class="d-flex justify-content-center">
                                <a href="{{ route('login') }}" class="logo d-flex align-items-center w-auto">

                                    <span class="d-none d-lg-block">User Registration </span>
                                </a>
                            </div>
                            <br>

                            <form method="POST" action="{{ route('register_user') }}">
                                @csrf

                                <div class="card p-3">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab"
                                                data-bs-target="#tab1" type="button" role="tab">Step 1</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab"
                                                data-bs-target="#tab2" type="button" role="tab">Step 2</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab"
                                                data-bs-target="#tab3" type="button" role="tab">Step 3</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tab4-tab" data-bs-toggle="tab"
                                                data-bs-target="#tab4" type="button" role="tab">Step 4</button>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content pt-3">
                                        <!-- Step 1 -->
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                            <div class="mb-3">
                                                <label for="edit_firstname">First Name</label>
                                                <input type="text"
                                                    class="form-control spec_input @error('firstname') is-invalid @enderror"
                                                    id="edit_firstname" name="firstname" value="{{ old('firstname') }}">
                                                @error('firstname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_middlename">Middle Name</label>
                                                <input type="text"
                                                    class="form-control spec_input @error('middlename') is-invalid @enderror"
                                                    id="edit_middlename" name="middlename"
                                                    value="{{ old('middlename') }}">
                                                @error('middlename')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_lastname">Last Name</label>
                                                <input type="text"
                                                    class="form-control spec_input @error('lastname') is-invalid @enderror"
                                                    id="edit_lastname" name="lastname" value="{{ old('lastname') }}">
                                                @error('lastname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_suffix_id">Suffix</label>
                                                <select
                                                    class="form-control spec_input @error('suffix_id') is-invalid @enderror"
                                                    id="edit_suffix_id" name="suffix_id">
                                                    <option value="">Select Suffix</option>
                                                    @foreach ($suffix as $suffixs)
                                                        <option value="{{ $suffixs->id }}" {{ old('suffix_id') == $suffixs->id ? 'selected' : '' }}>
                                                            {{ $suffixs->description }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('suffix_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Step 2 -->
                                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                                            <div class="mb-3">
                                                <label for="edit_birthdate">Birthday</label>
                                                <input type="date"
                                                    class="form-control spec_input @error('birthdate') is-invalid @enderror"
                                                    id="edit_birthdate" name="birthdate" value="{{ old('birthdate') }}">
                                                @error('birthdate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_citizenship_id">Citizenship</label>
                                                <select
                                                    class="form-control spec_input @error('citizenship_id') is-invalid @enderror"
                                                    id="edit_citizenship_id" name="citizenship_id">
                                                    <option value="">Select Citizenship</option>
                                                    @foreach ($citizen as $citizens)
                                                        <option value="{{ $citizens->id }}" {{ old('citizenship_id') == $citizens->id ? 'selected' : '' }}>
                                                            {{ $citizens->description }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('citizenship_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_department_id">Department</label>
                                                <select
                                                    class="form-control spec_input @error('department_id') is-invalid @enderror"
                                                    id="edit_department_id" name="department_id">
                                                    <option value="">Please Select Department</option>
                                                    @foreach ($department as $departments)
                                                        <option value="{{ $departments->id }}" {{ old('department_id') == $departments->id ? 'selected' : '' }}>
                                                            {{ $departments->description }}
                                                        </option>
                                                    @endforeach
                                                    <!-- Add options here -->
                                                </select>
                                                @error('department_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_civil_status_id">Civil Status</label>
                                                <select
                                                    class="form-control spec_input @error('civil_status_id') is-invalid @enderror"
                                                    id="edit_civil_status_id" name="civil_status_id">
                                                    <option value="">Please Select Civil Status</option>
                                                    @foreach ($civil as $civils)
                                                        <option value="{{ $civils->id }}" {{ old('civil_status_id') == $civils->id ? 'selected' : '' }}>
                                                            {{ $civils->description }}
                                                        </option>

                                                    @endforeach
                                                    <!-- Add options here -->
                                                </select>
                                                @error('civil_status_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Step 3 -->
                                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                                            <input type="hidden" id="edit_id" name="id" value="{{ old('id') }}">
                                            <div class="mb-3">
                                                <label for="edit_gender_id">Gender</label>
                                                <select
                                                    class="form-control spec_input @error('gender_id') is-invalid @enderror"
                                                    id="edit_gender_id" name="gender_id">
                                                    <option value="">Please Select Gender</option>
                                                    @foreach ($gender as $genders)
                                                        <option value="{{ $genders->id }}" {{ old('gender_id') == $genders->id ? 'selected' : '' }}>
                                                            {{ $genders->description  }}
                                                        </option>

                                                    @endforeach

                                                </select>
                                                @error('gender_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_user_email">Email</label>
                                                <input type="email"
                                                    class="form-control spec_input @error('user_email') is-invalid @enderror"
                                                    id="edit_user_email" name="user_email"
                                                    value="{{ old('user_email') }}">
                                                @error('user_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_contact_no">Contact Number</label>
                                                <input type="text"
                                                    class="form-control spec_input @error('contact_no') is-invalid @enderror"
                                                    id="edit_contact_no" name="contact_no"
                                                    value="{{ old('contact_no') }}">
                                                @error('contact_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_user_title">Position Name</label>
                                                <input type="text"
                                                    class="form-control spec_input @error('user_title') is-invalid @enderror"
                                                    id="edit_user_title" name="user_title"
                                                    value="{{ old('user_title') }}">
                                                @error('user_title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Step 4 -->
                                        <div class="tab-pane fade" id="tab4" role="tabpanel">
                                            <div class="mb-3">
                                                <label for="edit_username">Username</label>
                                                <input type="text"
                                                    class="form-control spec_input @error('username') is-invalid @enderror"
                                                    id="edit_username" name="username" oninput="Convert_uppercase(this)"
                                                    value="{{ old('username') }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="mb-3">
                                                <label for="yourPassword">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" name="password" value="{{ old('password') }}"
                                                        class="form-control spec_input @error('password') is-invalid @enderror"
                                                        id="yourPassword" required style="padding-right: 40px;">

                                                    <span class="toggle-password" onclick="togglePasswordVisibility()"
                                                        style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 18px; color: gray;">
                                                        👁️
                                                    </span>

                                                    @error('password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label><strong>Select Roles:</strong></label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($role as $roles)
                                                        <div style="width: 48%;">
                                                            <div class="form-check">
                                                                <input class="form-check-input update_role spec_input"
                                                                    type="checkbox" value="{{ $roles->id }}"
                                                                    id="role_{{ $roles->id }}" name="roles[]">
                                                                <label class="form-check-label spec_input"
                                                                    for="role_{{ $roles->id }}">
                                                                    {{ $roles->role }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if ($errors->has('roles'))
                                                    <small class="text-danger d-block mt-1">
                                                        Please select at least one role.
                                                    </small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button type="submit" class="btn btn-primary">
                                                Register
                                            </button>
                                        </div>



                                    </div>
                                </div>
                            </form>


                        </div>

                    </div>


                </div>
            </section>
        </div>

    </main>



    @include('includes.scripts')

    <!-- <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('yourPassword');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.style.color = 'blue';
            } else {
                passwordField.type = 'password';
                toggleIcon.style.color = 'black';
            }
        }

        function Convert_uppercase(inputElement) {
            const caretPosition = inputElement.selectionStart;
            inputElement.value = inputElement.value.toUpperCase();
            inputElement.setSelectionRange(caretPosition, caretPosition);
        }
    </script>

</body> -->


    <script>
        function Convert_uppercase(inputElement) {
            const caretPosition = inputElement.selectionStart;
            inputElement.value = inputElement.value.toUpperCase();
            inputElement.setSelectionRange(caretPosition, caretPosition);
        }

        function togglePasswordVisibility() {
            try {
                const passwordField = document.getElementById("yourPassword");
                if (!passwordField) throw new Error("Password input not found");

                if (passwordField.value.trim() === "") return;
                passwordField.type = passwordField.type === "password" ? "text" : "password";
            } catch (error) {
                console.error("Error toggling password visibility:", error);
            }
        }
    </script>

    @if(session('registration_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('registration_success') }}",
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        </script>
    @endif

</html>