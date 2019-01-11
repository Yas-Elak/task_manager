@extends('layouts.master')

@section('content')
    <h1 class="col-md-10">Project</h1>

    <div class="list-group col-md-10" id="user-info">
        <div class="clearfix split-items">
            <p  class="list-group-item left-side">ID</p>
            <p  class="list-group-item right-side ">{{$project->id}}</p>
        </div>        <div class="clearfix split-items">
            <p  class="list-group-item left-side">Subject</p>
            <p  class="list-group-item right-side ">{{$project->subject}}</p>
        </div>
        <div class="clearfix split-items">
            <p  class="list-group-item left-side">Description</p>
            <p  class="list-group-item right-side ">{{$project->description}}</p>
        </div>
        <div class="clearfix split-items">
            <p  class="list-group-item left-side">Status</p>
            <p style="background-color:{{$project->status->color}}" class="list-group-item right-side ">{{$project->status->name}}</p>
        </div>
        <div class="clearfix split-items">
            <p  class=" list-group-item left-side">Priority</p>
            <p style="background-color:{{$project->priority->color}}" class="list-group-item right-side ">{{$project->priority->name}}</p>
        </div>
        @foreach($project->users as $user)
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Assignated User {{ $loop->iteration }} : Last_name</p>
                <p  class="list-group-item right-side ">{{$user->last_name}}</p>
            </div>
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Assignated User {{$loop->iteration }} : Email</p>
                <p  class="list-group-item right-side ">{{$user->email}}</p>
            </div>
        @endforeach
        @foreach($project->tasks->where('status_id', 1) as $openedTasks)
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Open Task Name</p>
                <a href="{{route('tasks.show', $openedTasks->id)}}"> <p  class="list-group-item right-side ">{{$openedTasks->subject}}</p></a>
            </div>
        @endforeach
        @foreach($project->tasks->where('status_id', 2) as $closedTasks)
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Closed Task Name</p>
                <a href="{{route('tasks.show', $closedTasks->id)}}"><p  class="list-group-item right-side ">{{$closedTasks->subject}}</p></a>
            </div>
            <p>Task Name: {{$closedTasks->subject}}</p>
        @endforeach
        <div class="clearfix split-items">
            <p  class="list-group-item left-side">Active</p>
            <p  class="list-group-item right-side ">{{$project->is_active == 1 ? 'Active' : 'Not active'}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Project Created at</p>
            <p class="list-group-item right-side ">{{$project->created_at->format('d-m-y')}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Project updated at</p>
            <p class="list-group-item right-side ">{{$project->updated_at->format('d-m-y')}}</p>
        </div>
    </div>

    @if(Auth::check())
        <!-- Comments Form -->
        <div class="well col-md-10">
            @if(Session('comment_message_success'))
                <div class="alert alert-info">
                    <strong>Info! </strong>{{Session('comment_message_success')}}
                </div>
            @endif
            <h4>Leave a Comment:</h4>

            {!! Form::open(['method'=>'POST', 'action'=>'CommentsController@store'])!!}

            {{ Form::hidden('project_id', $project->id) }}

            <div class="form-group">
                {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>2])!!}
                <span class="text-danger">{{ $errors->first('body') }}</span>

            </div>
            <div class="form-group">
                {!! Form::submit('Submit comment', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}

        </div>
    @endif

    @if($comments)
        <!-- Comment -->
        @foreach($comments as $comment)
            <div class="panel panel-default col-md-10">
                <h4 class="media-heading">{{$comment->user->last_name . ' ' . $comment->user->first_name}}
                    <small>{{$comment->created_at->diffForHumans()}}</small>
                </h4>
                <div class="panel-body">
                    <p>{{$comment->body}}</p>
                    @if($comment->user_id == Auth::user()->id or Auth::user()->isAdmin())
                        {!! Form::open(['method'=>'DELETE', 'action'=>['CommentsController@destroy', $comment->id]])!!}
                        <div class="form-group">
                            {!! Form::submit('Delete', ['class'=>'btn btn-danger sm']) !!}
                        </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        @endforeach
    @endif







@endsection