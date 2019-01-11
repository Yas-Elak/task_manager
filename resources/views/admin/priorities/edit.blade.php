@extends('layouts.master')


@section('content')
    <h1 class="col-md-10">Edit Priority</h1>

    <div class="col-sm-6">
        {!! Form::model($priority, ['method'=>'PATCH', 'action'=>['AdminPrioritiesController@update', $priority->id]])!!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('name') }}</span>
        </div>
        <div class="form-group">
            {!! Form::label('color', 'Color') !!}
            {!! Form::color('color', $priority->color, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), $priority->is_active,['class'=>'form-control'])!!}
        </div>

        <div class="form-group">
            {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}

    </div>

@endsection