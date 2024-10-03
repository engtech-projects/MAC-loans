@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">

		<release-entry 
        pbranch="{{Session::get('branch')->branch_id}}" 
        idtype="{{json_encode(config('enums.id_type'))}}" 
        releasetype="{{json_encode(config('enums.release_type'))}}" 
        title="Release Entry" 
        token="{{Session::get('token')}}" 
        staff="{{Session::get('fullname')}}" 
        branch_mgr="{{Session::get('branch')->branch_manager}}"
        branch_code="{{Session::get('branch')->branch_code}}"
        branch_name="{{Session::get('branch')->branch_name}}"
        ></release-entry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection