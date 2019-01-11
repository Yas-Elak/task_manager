@extends('layouts.master')


@section('content')


    <h1 class="col-md-10">Create project</h1>

    <div class="col-sm-6">
        {!! Form::open(['method'=>'POST', 'action'=>'ProjectsController@store'])!!}
        <div class="form-group">
            {!! Form::label('subject', 'Subject') !!}
            {!! Form::text('subject', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('subject') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('description') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), 1,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('is_active') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('manager_id', 'Manager') !!}
            {!! Form::select('manager_id', $users, null, ['class'=>'form-control']) !!}
            <span class="text-danger">{{ $errors->first('manager_id') }}</span>

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
        <div class="form-group">
            {!! Form::label('is_active', 'Active ?') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), 1,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('is_active') }}</span>
        </div>
        <div class="form-group">
            {!! Form::submit('Create Project', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}

    </div>

@endsection