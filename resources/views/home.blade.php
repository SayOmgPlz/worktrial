@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            @include('tasks.tasks-list',  array('tasks' => $tasks) )
		</div>
	</div>
</div>
@endsection
