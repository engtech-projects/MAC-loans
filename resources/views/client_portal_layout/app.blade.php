<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> {{isset($title)? $title : 'MAC | Dashboard'}} </title>
  
  @include('client_portal_includes.styles')
 
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="to-print"></div>
<!-- Site wrapper -->
<div class="wrapper no-print">

  @include('client_portal_includes.topbar')

  @include('client_portal_includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="app">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

@include('client_portal_includes.scripts')
@yield('footer-scripts')
</body>
</html>
