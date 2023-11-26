<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __(config('app.name')) }} | {{ __($title) ?? 'Untitled' }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
          rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('admin/plugins/toastr/toastr.min.css')}}">
    <!-- Custom CSS & Scripts-->
{{--    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">--}}
    {{ $slot }}
    <style>
        .new-theme .sidebar-primary
        {
            background-color: #EFEFEF !important;
        }
        .new-theme .nav-pills .nav-link.active, .new-theme .nav-pills .show>.nav-link {
            color: #fff !important;
            background-color: #FE574B !important;
        }
        .new-theme .nav-pills .nav-link {
            color: #FE574B !important;
            background-color: #fff !important;
        }
        .new-theme .card-primary:not(.card-outline)>.card-header {
            background-color: #FE574B !important;
        }
        .new-theme .card-primary:not(.card-outline)>.card-header, .new-theme .card-primary:not(.card-outline)>.card-header a {
            color: #fff !important;
        }
        .new-theme .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-new-primary, .new-theme .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary {
            color: #fff !important;
            background: #FE574B !important;
        }
        .new-theme .bootstrap-switch-container .bootstrap-switch-label
        {
            color: #FE574B !important;
        }
        .new-theme .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-default, .new-theme .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-default {
            background: #ACACAC;
             color: #fff!important;
        }
        .new-theme a {
            color: #FE574B !important;
        }
        .new-theme .btn, .new-theme .small-box a{
            color: #fff !important;
        }
        .new-theme .btn-link {
            color: #FE574B !important;
        }
        .new-theme .btn-primary {
            background-color: #FE574B !important;
            border-color: #FE574B !important;
        }
        .new-theme .btn-secondary {
            background-color: #ACACAC !important;
            border-color: #ACACAC !important;
        }
        .new-theme .select2-container--default .select2-results__option--highlighted[aria-selected], .new-theme .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: #FE574B !important;
        }
        .new-theme .select2-container--default .select2-purple .select2-selection--multiple .select2-selection__choice, .new-theme .select2-purple .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #FE574B !important;
            border-color: #FE574B !important;
            /*padding-left: 20px !important;*/
        }
        .new-theme .select2-container--default .select2-purple .select2-selection--multiple .select2-selection__choice__remove, .new-theme .select2-purple .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            border-color: #FE574B !important;
            /*margin-left: 0 !important;*/
        }
        .new-theme .dropdown-item.active, .dropdown-item:active {
            background-color: #FE574B !important;
            color:#fff !important;
        }
        .new-theme .btn-close {
            position: relative;
            width: 30px;
            height: 30px;
            background-color: #FE574B;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .new-theme .btn-close::before,
        .new-theme .btn-close::after {
            content: '';
            position: absolute;
            height: 12px;
            width: 2px;
            background-color: #ffffff;
        }

        .new-theme .btn-close::before {
            transform: rotate(45deg);
        }

        .new-theme .btn-close::after {
            transform: rotate(-45deg);
        }

        .new-theme .btn-close:hover {
            background-color: #FC776D !important;
        }
        .new-theme .page-item.active .page-link {
            color: #fff !important;
            background-color: #FE574B !important;
            border-color: #FE574B !important;
        }

    </style>
</head>
