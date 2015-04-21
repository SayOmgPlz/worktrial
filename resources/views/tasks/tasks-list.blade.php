<div class="panel panel-default" id="task-list-head">
    <div class="panel-heading clearfix">
        <a href="javascript:;" class="col-md-2">Created</a>
        <a href="javascript:;" class="col-md-2">Owner</a>
        <a href="javascript:;" class="col-md-5">Description</a>
        <a href="javascript:;" class="col-md-2">State</a>
    </div>

    <div class="panel-body">

        @foreach ($tasks as $task)
        <p class="clearfix">
            <span class="col-md-2"> {{ $task->created_at }} </span>
            <span class="col-md-2"> {{ $task->owner() ? $task->owner()->first()->name : 'None' }} </span>
            <span class="col-md-5 hideOverflow"> {{ $task->description }} </span>
            <span class="col-md-2"> {{ $task->state ? 'opened' : 'closed' }} </span>
            <span class="col-mid-1"> <span class="icon-edit"> </span></span>
        </p>
        @endforeach
    </div>
</div>
