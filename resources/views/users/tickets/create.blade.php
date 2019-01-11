@extends('layouts.master')

@section('content')

    <h1 class="col-md-10">Create Ticket</h1>
    <div class="col-sm-6">

    {!! Form::open(['method'=>'POST', 'action'=>'TicketsController@store'])!!}

    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject', null, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('subject') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('project_id', 'Project') !!}
        {!! Form::select('project_id', $projects ,0, ['class'=>'form-control' ,'placeholder' => 'Select ...'])!!}
        <span class="text-danger">{{ $errors->first('project_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('task_id', 'Task') !!}
        {!! Form::select('task_id', $tasks ,0, ['class'=>'form-control', 'placeholder' => 'Select ...'])!!}
        <span class="text-danger">{{ $errors->first('task_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('agent_id', 'Agent') !!}
        {!! Form::select('agent_id', $users, 0, ['class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('agent_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('status_id', 'Status') !!}
        {!! Form::select('status_id', $statuses ,0, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('status_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('priority_id', 'Priority') !!}
        {!! Form::select('priority_id', $priorities ,0, ['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('priority_id') }}</span>
    </div>

    <div class="form-group">
        {!! Form::label('component_id', 'Components') !!}
        {!! Form::select('component_id', $components ,0, ['class'=>'form-control', 'placeholder' => 'Select ...'])!!}
    </div>

    <div class="form-group">
        {!! Form::label('is_active', 'Active ?') !!}
        {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), 1,['class'=>'form-control'])!!}
        <span class="text-danger">{{ $errors->first('is_active') }}</span>
    </div>

    <div class="form-group">
        {!! Form::submit('Create Ticket', ['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
    </div>

@endsection