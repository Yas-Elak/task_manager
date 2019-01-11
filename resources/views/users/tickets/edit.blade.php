@extends('layouts.master')

@section('content')

    <h1 class="col-md-10">Edit Ticket</h1>
    <div class="col-sm-6">

    {!! Form::model($ticket, ['method'=>'PATCH', 'action'=>['TicketsController@update', $ticket->id]])!!}

    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject', $ticket->subject, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('subject') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', $ticket->description, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('project_id', 'Project') !!}
        {!! Form::select('project_id', $projects ,$ticket->project, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('project_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('task_id', 'Task') !!}
        {!! Form::select('task_id', $tasks ,$ticket->task, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('task_id') }}</span>
    </div>


    <div class="form-group">
        {!! Form::label('agent_id', 'Agent') !!}
        {!! Form::select('agent_id', $users, $ticket->agent, ['class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('agent_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('status_id', 'Status') !!}
        {!! Form::select('status_id', $statuses ,$ticket->status, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('status_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('priority_id', 'Priority') !!}
        {!! Form::select('priority_id', $priorities ,$ticket->priority, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('priority_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('component_id', 'Components') !!}
        {!! Form::select('component_id', $components ,$ticket->component, ['class'=>'form-control', 'placeholder' => 'Select ...'])!!}
    </div>

    <div class="form-group">
        {!! Form::label('is_active', 'Active ?') !!}
        {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), $ticket->is_active,['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('is_active') }}</span>
    </div>

    <div class="form-group">
        {!! Form::submit('Update Ticket', ['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
    </div>
    @include('include.form_errors')

@endsection