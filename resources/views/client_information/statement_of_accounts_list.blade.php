@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<client-list title="Statement of Account List" url="{{route('client_information.statement_of_accounts_list')}}"></client-list>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection