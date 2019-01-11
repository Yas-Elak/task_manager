@extends('layouts.master')
@section('css')
@endsection
@section('content')
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
    <h1 class="col-md-3">Tasks</h1>
    <table id="table" class="table display cell-border embed-responsive">
        <thead>
        <tr id="column-search">
            <th scope="col">ID</th>
            <th scope="col">Subject</th>
            <th scope="col">Project</th>
            <th scope="col">Status</th>
            <th scope="col">Priority</th>
            <th scope="col">Start (wanted)</th>
            <th scope="col">End (wanted)</th>
            <th scope="col">Start (real)</th>
            <th scope="col">End (real)</th>
            <th scope="col">Created</th>
            <th scope="col">Updated</th>
            <th scope="col">Operations</th>
        </tr>
        </thead>
        <tbody>
        @if($tasks)
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td><a href="{{route('tasks.show', $task->id)}}">{{$task->subject}}</a></td>
                    <td>{{$task->project->subject}}</td>
                    <td><span class="td-status badge badge-pill"
                              style="background-color:{{$task->status->color}}">{{$task->status->name}}</span></td>
                    <td><span class="td-priority badge badge-pill"
                              style="background-color:{{$task->priority->color}}">{{$task->priority->name}}</span></td>
                    <td>{{$task->wanted_start_datetime->format('d/m/Y')}}</td>
                    <td>{{$task->wanted_end_datetime->format('d/m/Y')}}</td>
                    <td>{{$task->real_start_datetime === Null ? '' :$task->real_start_datetime->format('d/m/Y')}}</td>
                    <td>{{$task->real_end_datetime === Null ? '' : $task->real_end_datetime->format('d/m/Y')}}</td>
                    <td>{{$task->created_at->format('d/m/Y')}}</td>
                    <td>{{$task->updated_at->format('d/m/Y')}}</td>
                    @if( Auth::user()->isAdmin() OR Auth::user()->isAdmin() OR Auth::user()->id == $task->owner_id)
                        <td>
                            <a>
                                {!! Form::model($task, ['method' => 'delete',
                                 'route' => ['tasks.destroy', $task->id],
                                  'class' =>'form-inline delete-form',
                                   'data-id'=>$task->id]) !!}
                                <a href="{{route('tasks.edit', $task->id)}}">
                                    <button type="button" class="btn btn-info edit-item btn-form" }><i
                                                class="faw-form fas fa-edit"></i></button>
                                </a>
                                {{ Form::button('<i class="faw-form fas fa-trash-alt" aria-hidden="true"></i>',
                                 ['class' => 'btn btn-danger btn-form', 'id'=>"delete", 'type' => 'submit']) }}
                                {!! Form::close() !!}
                            </a>
                        </td>
                    @else
                        <td>None</td>
                    @endif
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    @include('layouts.modals.delete')

@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>

@endsection