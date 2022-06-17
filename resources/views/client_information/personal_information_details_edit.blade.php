@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<div class="mb-24"></div>
		<borrowers-info borrower_id="{{$id}}" token="{{Session::get('token')}}" pidtype="{{json_encode(config('enums.id_type'))}}" pclient="1"></borrowers-info>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection