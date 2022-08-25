@extends('client_portal_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<client-list token="{{Session::get('token')}}" title="Statement of Account List" url="{{route('client_information.account_statement_details', ['id'=>':id'])}}"></client-list>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection