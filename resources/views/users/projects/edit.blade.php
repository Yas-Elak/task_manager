@extends('layouts.master')


@section('content')
    <h1 class="col-md-10">Edit project</h1>

    <div class="col-sm-6">
        {!! Form::model($project, ['method'=>'PATCH', 'action'=>['ProjectsController@update', $project->id]])!!}
        <div class="form-group">
            {!! Form::label('subject', 'Subject') !!}
            {!! Form::text('subject', $project->subject, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('subject') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', $project->description, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('description') }}</span>
        </div>


        <div class="form-group">
            {!! Form::label('manager_id', 'Manager') !!}
            {!! Form::select('manager_id',$users, $project->manager_id,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('manager_id') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('user_id[]', 'Users') !!}
            {!! Form::select('user_id[]', $users, $selected_users, ['class'=>'form-control', 'multiple'=>'multiple']) !!}
            <small class="form-text text-muted">Hold CTRL to choose several users.</small>
        </div>

        <div class="form-row form-group">

            <div class="col">
                {!! Form::label('status_id', 'Status') !!}
                {!! Form::select('status_id', $statuses ,$project->status->name, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('status_id') }}</span>
            </div>

            <div class="col">
                {!! Form::label('priority_id', 'Priority') !!}
                {!! Form::select('priority_id', $priorities ,$project->priority->name, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('priority_id') }}</span>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), $project->is_active,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('is_active') }}</span>
        </div>

        <div class="form-group">
            {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}

    </div>

@endsection