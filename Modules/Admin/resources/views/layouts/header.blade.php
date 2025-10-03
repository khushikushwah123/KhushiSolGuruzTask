<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/dataTables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/fullcalendar-scheduler.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>

    <body class=" sidebar-mini layout-fixed">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand ">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a> </li>
                </ul>
            </nav>
