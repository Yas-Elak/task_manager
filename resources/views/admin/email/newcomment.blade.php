@extends('layouts.email')
@section('content')
    <h1>Hello you have a new comment from {{$data->user->email}}</h1>

    <table cellspacing="0" cellpadding="10" border="1">
        <tr>
            <td width="100">ID</td>
            <td width="280">{{$data->id}}</td>
        </tr>
        @if(!is_object($ticket))
        <tr>
            <td width="100">Project</td>
            <td width="280">{{(is_object($project)) ?  $project->subject : $task->project->subject}}</td>
        </tr>
        <tr>
            <td width="100">Task</td>
            <td width="280">{{(is_object($task)) ? $task->subject : '/' }}</td>
        </tr>
        @else
            <tr>
                <td width="100">Ticket</td>
                <td width="280">{{$ticket->subject}}</td>
            </tr>
            <tr>
                <td width="100">Project</td>
                <td width="280">{{(is_object($ticket->project)) ?  $ticket->project->subject : '/'}}</td>
            </tr>
            <tr>
                <td width="100">Task</td>
                <td width="280">{{(is_object($ticket->task)) ? $ticket->task->subject : '/' }}</td>
            </tr>
        @endif
        <tr>
            <td width="100">Content</td>
            <td width="280">{{$data->body}}</td>
        </tr>
        <tr>
            <td width="100">Created at</td>
            <td width="280">{{$data->created_at}}</td>
        </tr>
    </table>

@stop