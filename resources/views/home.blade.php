@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 task-list-container">
            <div class="panel panel-default">
                <div class="panel-heading clearfix" id="task-header" >
                    <a href="javascript:;" class="col-md-2" data-sort="created_at">Created</a>
                    <a href="javascript:;" class="col-md-2" data-sort="owner">Owner</a>
                    <a href="javascript:;" class="col-md-5" data-sort="description">Description</a>
                    <a href="javascript:;" class="col-md-2" data-sort="state">State</a>
                </div>


                @include('tasks.tasks-list',  array('tasks' => $tasks) )

                {{-- Make pagination work with the sorting  $tasks->render() --}}



            </div>
		</div>
	</div>
</div>
@endsection
