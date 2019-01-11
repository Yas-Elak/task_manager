@extends('layouts.email')
@section('content')
    <h1>Hello you have a update to the ticket : {{$data->subject}}</h1>

    <table cellspacing="0" cellpadding="10" border="1">
        <tr>
            <td width="100">ID</td>
            <td width="280">{{$data->id}}</td>
        </tr>
        <tr>
            <td width="100">Subject</td>
            <td width="280">{{$data->subject}}</td>
        </tr>
        <tr>
            <td width="100">Description</td>
            <td width="280">{{$data->description}}</td>
        </tr>
        <tr>
            <td width="100">Projet</td>
            <td width="280">{{$data->project->subject}}</td>
        </tr>
        <tr>
            <td width="100">Projet</td>
            <td width="280">{{$data->task->subject}}</td>
        </tr>
        <tr>
            <td width="100">Creator</td>
            <td width="280">{{$data->owner->email}}</td>
        </tr>
        <tr>
            <td width="100">Status</td>
            <td width="280" style="background-color:{{$data->status->color}}">{{$data->status->name}}</td>
        </tr>
        <tr>
            <td width="100">Priority</td>
            <td width="280" style="background-color:{{$data->priority->color}}">{{$data->priority->name}}</td>
        </tr>
        <tr>
            <td width="100">Created at</td>
            <td width="280">{{$data->created_at}}</td>
        </tr>
        <tr>
            <td width="100">updated at</td>
            <td width="280">{{$data->updated_at}}</td>
        </tr>


    </table>

@stop