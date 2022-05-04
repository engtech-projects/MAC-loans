@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<client-list token="{{Session::get('token')}}" title="Personal Information List" url="{{route('client_information.personal_information_details',['id'=>':id'])}}"></client-list>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection