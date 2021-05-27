<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>LRS Admin Blog</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />
    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>
</head>
<body>

<div id="app">
    @if (Auth::check())
        <mainapp :user="{{ Auth::user() }}" :permission="{{ Auth::user()->role->permission }}"></mainapp>
    @else
        <mainapp :user="false"></mainapp>
    @endif
</div>

<script src="{{ mix('js/app.js') }}"></script>
<!-- plugins:js -->
<script src="{{ asset('backend/vendors/base/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="{{ asset('backend/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('backend/js/off-canvas.js') }}"></script>
<script src="{{ asset('backend/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('backend/js/template.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('backend/js/dashboard.js') }}"></script>
<script src="{{ asset('backend/js/data-table.js') }}"></script>
<script src="{{ asset('backend/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('backend/js/dataTables.bootstrap4.js') }}"></script>
<!-- End custom js for this page-->
<script src="{{ asset('backend/js/jquery.cookie.js') }}" type="text/javascript"></script>
</body>

</html>
