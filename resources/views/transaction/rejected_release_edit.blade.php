@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<rejected-release-edit id="{{request()->id}}" title="Rejected Account - Edit Information" idtype="{{json_encode(config('enums.id_type'))}}"  token="{{Session::get('token')}}"></rejected-release-edit>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection