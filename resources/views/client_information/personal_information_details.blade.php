@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<personal-information borrower_id="{{$id}}" token="{{Session::get('token')}}" canedit="{{Auth::user()->hasAccess('edit borrower')?1:0}}"></personal-information>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection