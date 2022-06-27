@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<!-- <rejected-release-edit id="{{request()->id}}" title="Rejected Account - Edit Information"  token="{{Session::get('token')}}"></rejected-release-edit> -->
		<release-entry rejectid="{{request()->id}}" idtype="{{json_encode(config('enums.id_type'))}}" token="{{Session::get('token')}}" title="Rejected Account - Edit Information"></release-entry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection