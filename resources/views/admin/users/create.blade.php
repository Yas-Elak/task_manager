@extends('layouts.master')

@section('content')

    <h1 class="col-md-10">Create User</h1>
    <div class="col-sm-6">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminUsersController@store', 'files'=>true])!!}
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name') !!}
            {!! Form::text('last_name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('last_name') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('first_name', 'First Name') !!}
            {!! Form::text('first_name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('first name') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::text('email', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('role_id', 'Role') !!}
            {!! Form::select('role_id', $roles ,3, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('role_id') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), 1,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('is_active') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password', ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('password') }}</span>
        </div>

        <div class="form-group">
            {!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

@endsection