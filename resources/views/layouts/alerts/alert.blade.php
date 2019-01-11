@if(Session('created_task_success'))
    <div class="alert alert-success">
        <strong>Success! </strong>{{Session('created_task_success')}}
    </div>
@elseif(Session('created_task_failed'))
    <div class="alert alert-danger">
        <strong>Warning! </strong>{{Session('created_task_failed')}}
    </div>
@elseif(Session('task_updated'))
    <div class="alert alert-success">
        <strong>Success! </strong>{{Session('task_updated')}}
    </div>
@elseif(Session('task_deleted'))
    <div class="alert alert-info">
        <strong>Success! </strong>{{Session('task_deleted')}}
    </div>
@endif

{{--en test--}}