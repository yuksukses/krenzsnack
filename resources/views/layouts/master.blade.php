<!--
*
*  INSPINIA - Responsive Admin Theme
*  version 2.7
*
-->

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $setting->nama_perusahaan }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            position: relative;
        }

        .wrapper {
            min-height: 100vh;
            /* will cover the 100% of viewport */
            overflow: hidden;
            display: block;
            position: relative;
            padding-bottom: 100px;
            /* height of your footer */
        }
    </style>
    @stack('css')

</head>

<body>
    <div id="wrapper">
        {{-- navbar --}}
        @include('layouts.navbar')
        <div id="page-wrapper" class="gray-bg">
            {{-- Header --}}
            @include('layouts.header')
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper wrapper-content">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{ asset('js/validator.min.js')}}"></script>
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js')}}"></script>

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{ asset('js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js')}}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{ asset('js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js')}}"></script>
    <script>
        function preview(selector, temporaryFile, width = 200){
        $(selector).empty();
        $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
    }
    </script>
    @stack('scripts')
</body>

</html>