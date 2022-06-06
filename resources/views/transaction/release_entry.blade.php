@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<release-entry idtype="{{json_encode(config('enums.id_type'))}}" token="{{Session::get('token')}}"></release-entry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection