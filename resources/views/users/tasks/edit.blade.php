@extends('layouts.master')

@section('content')

    <h1 class="col-md-10">Edit Task</h1>
    <div class="col-sm-6">

        {!! Form::model($task, ['method'=>'PATCH', 'action'=>['TasksController@update', $task->id]])!!}

        <div class="form-group">
            {!! Form::label('subject', 'Subject') !!}
            {!! Form::text('subject', $task->subject, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('subject') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', $task->description, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('description') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('project_id', 'Project') !!}
            {!! Form::select('project_id', $projects ,$task->project, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('project_id') }}</span>
        </div>


        <div class="form-group">
            {!! Form::label('user_id[]', 'Users') !!}
            {!! Form::select('user_id[]', $users, $selected_users, ['class'=>'form-control', 'multiple'=>'multiple']) !!}
            <small class="form-text text-muted">Hold CTRL to choose several users.</small>
        </div>
        <div class="form-row form-group">

            <div class="col">
                {!! Form::label('status_id', 'Status') !!}
                {!! Form::select('status_id', $statuses ,$task->status, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('status_id') }}</span>
            </div>

            <div class="col">
                {!! Form::label('priority_id', 'Priority') !!}
                {!! Form::select('priority_id', $priorities ,$task->priority, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('priority_id') }}</span>
            </div>
        </div>
        <div class="form-row form-group">

            <div class="col">
                {!! Form::label('wanted_start_datetime', 'Wanted starting date') !!}
                {!! Form::date('wanted_start_datetime' ,$task->wanted_start_datetime, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('wanted_start_datetime') }}</span>
            </div>

            <div class="col">
                {!! Form::label('wanted_end_datetime', 'Wanted ending date') !!}
                {!! Form::date('wanted_end_datetime' ,$task->wanted_end_datetime, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('wanted_end_datetime') }}</span>
            </div>
        </div>
        <div class="form-row form-group">

            <div class="col">
                {!! Form::label('real_start_datetime', 'Real starting date') !!}
                {!! Form::date('real_start_datetime' ,$task->real_start_datetime, ['class'=>'form-control'])!!}
            </div>

            <div class="col">
                {!! Form::label('real_end_datetime', 'Real Ending date') !!}
                {!! Form::date('real_end_datetime' ,$task->real_end_datetime, ['class'=>'form-control'])!!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::submit('Edit Task', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

@endsection