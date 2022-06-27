@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<div class="mb-24"></div>
		<borrower-container borrower_id="{{$id}}" token="{{Session::get('token')}}" idtype="{{json_encode(config('enums.id_type'))}}" pclient="1"></borrower-container>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection