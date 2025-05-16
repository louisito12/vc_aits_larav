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
    </style>

    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('new_assets/assets/img/vc_red2.png') }}" alt="">
                                    <span class="d-none d-lg-block">VC-AITS
                                    </span>
                                </a>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login</h5>

                                    </div>

                                    <form class="row g-3 needs-validation" method="POST"
                                        action="{{ route('login_function') }}">
                                        @csrf
                                        <div class="col-12" style="font-size: 12px;padding: 2px;">
                                            <label for="yourUsername" class="form-label"><b>Username</b></label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="username" value="{{ old('username') }}"
                                                    class="form-control" id="yourUsername"
                                                    oninput="Convert_uppercase(this)" required>
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12" style="font-size: 12px; padding: 2px;">
                                            <label for="yourPassword" class="form-label"><b>Password</b></label>
                                            <div class="input-container" style="position: relative;">
                                                <input type="password" name="password" value="{{ old('password') }}"
                                                    class="form-control" id="yourPassword" required>
                                                <span class="toggle-password" onclick="togglePasswordVisibility()"
                                                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 18px; color: black;">
                                                    👁️
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                            @if (Session::has('error'))
                                                <br>
                                                <hr>
                                                <div class="alert alert-danger">
                                                    {{ Session::get('error') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="#">Create an
                                                    account</a>
                                            </p>
                                        </div>
                                    </form>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>



    @include('includes.scripts')

    <script>
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

</body>


</html>