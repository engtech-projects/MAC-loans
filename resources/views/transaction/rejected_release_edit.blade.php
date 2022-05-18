@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<rejected-release-edit id="{{request()->id}}" title="Rejected Account - Edit Information"  token="{{Session::get('token')}}"></rejected-release-edit>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection