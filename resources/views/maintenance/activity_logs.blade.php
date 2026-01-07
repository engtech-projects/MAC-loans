@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
        <activity-logs token="{{ Session::get('token') }}"></activity-logs>
    </section>
    <!-- /.content -->
    <!-- MODALS  -->
    </div>
@endsection
