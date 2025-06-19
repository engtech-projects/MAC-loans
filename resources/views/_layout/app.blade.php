<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ url('favicon.ico') }}">
  <title> {{isset($title)? $title : 'MAC | Dashboard'}} </title>
  
  @include('_includes.styles')
 
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="to-print"></div>
<!-- Site wrapper -->
<div class="wrapper no-print">

  @include('_includes.topbar')

  @include('_includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="app">
	<current-transactiondate branch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}"></current-transactiondate>
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

@include('_includes.scripts')
@yield('footer-scripts')
</body>
</html>
