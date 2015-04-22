<ul class="panel-body" id="task-list">
 {{-- Fix "owner" is making n+1 queries(even with "with" stated) --}}
        @foreach ($tasks as $task)
        <li class="clearfix" id="task-{{ $task->id }}">
            <span class="col-md-2"> {{ $task->created_at }} </span>
            <span class="col-md-2"> {{ $task->owner() ? $task->owner()->first()->name : 'None' }} </span>
            <span class="col-md-5 hideOverflow"> {{ $task->description }} </span>
            <span class="col-md-2"> {{ $task->state ? 'opened' : 'closed' }} </span>
            <span class="col-mid-1"> <a href="javascript:;" class="icon-edit"> </a></span>
        </li>
        @endforeach
</ul>

