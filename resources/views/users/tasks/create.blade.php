@extends('layouts.master')

@section('content')

    <h1 class="col-md-10">Create Task</h1>

    <div class="col-sm-6">

        {!! Form::open(['method'=>'POST', 'action'=>'TasksController@store'])!!}

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
            {!! Form::select('project_id', $projects ,0, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('project_id') }}</span>
        </div>


        <div class="form-group">
            {!! Form::label('user_id[]', 'Users') !!}
            {!! Form::select('user_id[]', $users, null, ['class'=>'form-control', 'multiple'=>'multiple']) !!}
            <small class="form-text text-muted">Hold CTRL to choose several users.</small>
        </div>
        <div class="form-row form-group">
            <div class="col">
                {!! Form::label('status_id', 'Status') !!}
                {!! Form::select('status_id', $statuses ,0, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('status_id') }}</span>
            </div>

            <div class="col">
                {!! Form::label('priority_id', 'Priority') !!}
                {!! Form::select('priority_id', $priorities ,0, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('priority_id') }}</span>
            </div>
        </div>
        <div class="form-row form-group">
            <div class="col">
                {!! Form::label('wanted_start_datetime', 'Starting date') !!}
                {!! Form::date('wanted_start_datetime' ,0, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('wanted_start_datetime') }}</span>
            </div>

            <div class="col">
                {!! Form::label('wanted_end_datetime', 'Ending date') !!}
                {!! Form::date('wanted_end_datetime' ,0, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('wanted_end_datetime') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::submit('Create Task', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

@endsection