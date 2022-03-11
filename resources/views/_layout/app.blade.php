<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> {{isset($title)? $title : 'Title'}} </title>
  
  @include('_includes.styles')
 
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">

  @include('_includes.topbar')

  @include('_includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="app">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

@include('_includes.scripts')
@yield('footer-scripts')
</body>
</html>
