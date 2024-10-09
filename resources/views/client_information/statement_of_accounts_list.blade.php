@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<client-list pbranch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}" title="Statement of Account List" url="{{route('client_information.account_statement_details', ['id'=>':id'])}}"></client-list>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection