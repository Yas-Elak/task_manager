@extends('layouts.master')

@section('content')
    <div class="container col-md-6">
        <div class="list-group" id="user-info">
            <p class="list-group-item" >Photo</p>
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Email</p>
                <p  class="list-group-item right-side ">{{$user->email}}</p>
            </div>
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Last name</p>
                <p  class="list-group-item right-side ">{{$user->last_name}}</p>
            </div>
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">First name</p>
                <p  class="list-group-item right-side ">{{$user->first_name}}</p>
            </div>
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Role</p>
                <p  class="list-group-item right-side ">{{$user->role->name}}</p>
            </div>
            <div class="clearfix split-items">
                <p  class="list-group-item left-side">Status</p>
                <p  class="list-group-item right-side ">{{$user->is_active == 1 ? 'Active' : 'Not active'}}</p>
            </div>
        </div>
        <button id="password-change" class="btn btn-danger">Change password</button>


        <div class="col-md-6" id="password-change-form">

            {!! Form::model($user, ['method'=>'PATCH', 'action'=>['UsersController@update', $user->id]])!!}

            <div class="form-group">
                {!! Form::label('current_password', 'Current password') !!}
                {!! Form::password('current_password',null, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('current_password') }}</span>
            </div>

            <div class="form-group">
                {!! Form::label('password', 'New Password') !!}
                {!! Form::password('password', null, ['class'=>'form-control'])!!}
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'New password Confirmation') !!}
                {!! Form::password('password_confirmation', null,['class'=>'form-control', 'name'=>'password_confirmation'])!!}
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

            </div>


            <div class="form-group">
                {!! Form::submit('Update password', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>

        @if(Session('password_changed'))
            <div class="alert alert-success">
                <strong>Success!</strong>{{Session('password_changed')}}
            </div>
        @elseif(Session('password_changed_failed'))
            <div class="alert alert-danger">
                <strong>Warning!</strong>{{Session('password_changed_failed')}}
            </div>
        @endif

    </div>




    <div class="col-md-6">
        <div class="list-group">
        <h4 class="list-group-item title-notification">Projects</h4>
            {{--<div class="list-group-item">--}}
            {!! Form::model($option, ['method'=>'PATCH', 'action'=>['OptionsController@update', $option->id]])!!}
            <div class="form-group list-group-item ">
            {{ Form::hidden('project_notification', 0) }}
            {!! Form::label('project_notification', 'Projects Notifications', ['class'=>'col-md-4']) !!}
                {!! Form::checkbox('project_notification', 1, $option->project_notification == true ? true : false, ['class'=>'form-control'])!!}
        </div>
                {{--</div>--}}
        <div class="form-group list-group-item">
            {{ Form::hidden('project_email', 0) }}
            {!! Form::label('project_email', 'Projects Emails', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('project_email', 1, $option->project_email == true ? true : false,['class'=>'form-control'])!!}
        </div>
        <h4 class="list-group-item title-notification">Tasks</h4>
        <div class="form-group list-group-item">
            {{ Form::hidden('task_notification', 0) }}
            {!! Form::label('task_notification', 'Tasks Notifications', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('task_notification',1, $option->task_notification == true ? true : false, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group list-group-item">
            {{ Form::hidden('task_email', 0) }}
            {!! Form::label('task_email', 'Tasks Emails', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('task_email',1, $option->task_email == 1 ? true : false, ['class'=>'form-control'])!!}
        </div>
        <h4 class="list-group-item title-notification">Tickets</h4>
        <div class="form-group list-group-item">
            {{ Form::hidden('ticket_notification', 0) }}
            {!! Form::label('ticket_notification', 'Tickets Notifications', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('ticket_notification',1, $option->ticket_notification == 1 ? true : false, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group list-group-item">
            {{ Form::hidden('ticket_email', 0) }}
            {!! Form::label('ticket_email', 'Tickets Emails', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('ticket_email',1, $option->ticket_email == 1 ? true : false, ['class'=>'form-control'])!!}
        </div>
        <h4 class="list-group-item title-notification">Comments</h4>
        <div class="form-group list-group-item">
            {{ Form::hidden('comment_notification', 0) }}
            {!! Form::label('comment_notification', 'Comments Notifications', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('comment_notification',1, $option->comment_notification == 1 ? true : false, ['class'=>'form-control'])!!}
        </div>
        <div class="form-group list-group-item">
            {{ Form::hidden('comment_email', 0) }}
            {!! Form::label('comment_email', 'Comments Emails', ['class'=>'col-md-4']) !!}
            {!! Form::checkbox('comment_email',1, $option->comment_email == 1 ? true : false, ['class'=>'form-control'])!!}
        </div>

        <div class="form-group list-group-item">
            {!! Form::submit('Save preferences', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#password-change-form').hide();

        $("#password-change").click(function(){
            $('#password-change-form').toggle();
        });
    </script>

@endsection

