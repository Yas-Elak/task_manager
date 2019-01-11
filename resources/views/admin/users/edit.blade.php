@extends('layouts.master')

@section('content')

    <h1>Edit Users</h1>
    <div class="col-sm-3">

        @if($user->photo )
            <img src="{{$user->photo->file}}" alt="" class="img-responsive img-rounded">
        @else
            <img src="/images/no-avatar.png" alt="" class="img-responsive img-rounded">

        @endif
    </div>

    <div class="col-sm-9">

        {!! Form::model($user, ['method'=>'PATCH', 'action'=>['AdminUsersController@update', $user->id]])!!}
        <div class="form-group">
            {!! Form::label('last_name', 'Last name') !!}
            {!! Form::text('last_name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('last_name') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('first_name', 'First name') !!}
            {!! Form::text('first_name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('first name') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::text('email', null, ['class'=>'form-control', 'disabled'=>'disabled'])!!}
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('role_id', 'Role') !!}
            {!! Form::select('role_id', $roles , $user->role_id, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('role_id') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), $user->is_active,['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('is_active') }}</span>
        </div>

        <div class="form-group">
            {!! Form::submit('Update User', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}

    </div>

@endsection