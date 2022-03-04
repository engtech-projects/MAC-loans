@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<center-ao days="{{json_encode(config('enums.days'))}}"></center-ao>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection