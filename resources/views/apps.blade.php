<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.headers')
</head>

<body>

    <style>
   
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
       
        }


        .loader {
            border: 16px solid #f3f3f3;
     
            border-top: 16px solid #3498db;
     
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        .spec_input {
            font-size: 12px;
            padding: 2px;
        }


        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- ======= Header ======= -->

    @include('includes.head_nav')

    <!-- End Header -->

    <!-- ======= Sidebar ======= -->

    @include('includes.sidebar')
    <!-- End Sidebar-->


    <div class="overlay">
        <div class="loader"></div>
    </div>




    <main id="main" class="main">



        @yield('section')

    </main>


    <!-- End #main -->


    <!-- ======= Footer ======= -->
    @include('includes.footer')

    <!-- End Footer -->



    <!-- Scripts -->
    @include('includes.scripts')
    <!-- scripts -->






    @yield('script')

    <script>
        $(document).ready(function () {

            setTimeout(function () {
                $('.overlay').fadeOut();
                $('.content').fadeIn();
                $('.modal_hider').removeAttr('hidden');
            }, 1000);
        });
    </script>

</body>

</html>