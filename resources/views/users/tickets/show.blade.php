@extends('layouts.master')

@section('content')

    <h1 class="col-md-10">Ticket</h1>

    <div class="list-group col-md-10" id="user-info">
        <div class="clearfix split-items">
            <p class="list-group-item left-side">ID</p>
            <p class="list-group-item right-side ">{{$ticket->id}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Subject</p>
            <p class="list-group-item right-side ">{{$ticket->subject}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Description</p>
            <p class="list-group-item right-side ">{{$ticket->description}}</p>
        </div>
        <div class="clearfix split-items">
            @if($ticket->project)
                <p class="list-group-item left-side">Linked Project</p>
                <a href="{{route('projects.show', $ticket->project->id)}}"><p
                            class="list-group-item right-side ">{{$ticket->project->subject}}</p></a>
            @endif
            @if($ticket->task)
                <p class="list-group-item left-side">Linked Task</p>
                <a href="{{route('tasks.show', $ticket->task->id)}}"><p
                            class="list-group-item right-side ">{{$ticket->task->subject}}</p></a>
            @endif
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Ticket owner Last Name</p>
            <p class="list-group-item right-side ">{{$ticket->owner->last_name}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Ticket owner Email</p>
            <p class="list-group-item right-side ">{{$ticket->owner->email}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Ticket agent Last Name</p>
            <p class="list-group-item right-side ">{{$ticket->agent->last_name}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Ticket agent Email</p>
            <p class="list-group-item right-side ">{{$ticket->agent->email}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Status</p>
            <p style="background-color:{{$ticket->status->color}}"
               class="list-group-item right-side ">{{$ticket->status->name}}</p>
        </div>
        <div class="clearfix split-items">
            <p class=" list-group-item left-side">Priority</p>
            <p style="background-color:{{$ticket->priority->color}}"
               class="list-group-item right-side ">{{$ticket->priority->name}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Active</p>
            <p class="list-group-item right-side ">{{$ticket->is_active == 1 ? 'Active' : 'Not active'}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Ticket Created at</p>
            <p class="list-group-item right-side ">{{$ticket->created_at->format('d-m-y')}}</p>
        </div>
        <div class="clearfix split-items">
            <p class="list-group-item left-side">Ticket updated at</p>
            <p class="list-group-item right-side ">{{$ticket->updated_at->format('d-m-y')}}</p>
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

            {{ Form::hidden('ticket_id', $ticket->id) }}

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

