@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <h1 class="col-md-10">Comments</h1>
    <table id="table" class="table display cell-border">
        <thead>
        <tr id="column-search">
            <th scope="col">id</th>
            <th scope="col">Source</th>
            <th scope="col">author last name</th>
            <th scope="col">author email</th>
            <th scope="col">body</th>
            <th scope="col">Approbation</th>
            <th scope="col">Operation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{$comment->id}}</td>
                <td>
                    @if($comment->ticket)
                        <a href="{{route('tickets.show',$comment->ticket->id)}}">Ticket : {{$comment->ticket->subject}}</a>
                    @elseif($comment->task)
                        <a href="{{route('tasks.show',$comment->task->id)}}">Task : {{$comment->task->subject}}</a>
                    @elseif($comment->project)
                        <a href="{{route('projects.show',$comment->project->id)}}">Project : {{$comment->project->subject}}</a>
                    @else
                        <p>No source</p>
                    @endif

                </td>
                <td>{{$comment->user->last_name}}</td>
                <td>{{$comment->user->email}}</td>
                <td>{{$comment->body}}</td>
                <td>
                    {!! Form::open(['method'=>'PATCH', 'action'=>['CommentsController@update', $comment->id]])!!}
                    <div class="form-group">
                        @if($comment->moderate == 1)
                            <input type="hidden" name="moderate" value="0">
                            {!! Form::submit('Unapprouve', ['class'=>'btn btn-warning']) !!}
                        @else
                            <input type="hidden" name="moderate" value="1">
                            {!! Form::submit('Approuve', ['class'=>'btn btn-success']) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
                <td>
                    <a>
                        {!! Form::model($comment, ['method' => 'delete',
                         'route' => ['comments.destroy', $comment->id],
                          'class' =>'form-inline delete-form',
                           'data-id'=>$comment->id]) !!}
                        {{ Form::button('<i class="faw-form fas fa-trash-alt" aria-hidden="true"></i>',
                         ['class' => 'btn btn-danger btn-form', 'id'=>"delete", 'type' => 'submit']) }}
                        {!! Form::close() !!}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('layouts.modals.delete')
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
@endsection