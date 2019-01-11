@extends('layouts.master')
@section('css')
@endsection
@section('content')
    <h1 class="col-md-10">Users</h1>

    @if(Session('created_user_by_admin_success'))
        <div class="alert alert-success">
            <strong>Success! </strong>{{Session('created_user_by_admin_success')}}
        </div>
    @elseif(Session('deleted_user_by_admin_success'))
        <div class="alert alert-success">
            <strong>Success! </strong>{{Session('deleted_user_by_admin_success')}}
        </div>
    @elseif(Session('updated_user_by_admin_success'))
        <div class="alert alert-info">
            <strong>Success! </strong>{{Session('updated_user_by_admin_success')}}
        </div>
    @endif

    <table id="table" class="table display cell-border embed-responsive" >
        <thead>
        <tr id="column-search">
            <th scope="col">ID</th>
            <th scope="col">Photo</th>
            <th scope="col">First_Name</th>
            <th scope="col">Last_Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Status</th>
            <th scope="col">Created</th>
            <th scope="col">Updated</th>
            <th scope="col">Operation</th>
        </tr>
        </thead>
        <tbody>
        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    @if($user->photo )
                        <td><img height="25px" src="{{asset('images/'.$user->photo->file)}}" alt=""></td>
                    @else
                        <td>/</td>
                    @endif
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>{{$user->is_active == 1 ? 'Active' : 'Not active'}}</td>
                    <td>{{$user->created_at->format('d/m/Y')}}</td>
                    <td>{{$user->updated_at->format('d/m/Y')}}</td>
                    <td>
                        <a>
                            {!! Form::model($user, ['method' => 'delete',
                             'route' => ['admin.users.destroy', $user->id],
                              'class' =>'form-inline delete-form',
                               'data-id'=>$user->id]) !!}
                            <a href="{{route('admin.users.edit', $user->id)}}">
                                <button type="button" class="btn btn-info edit-item btn-form" }><i
                                            class="faw-form fas fa-edit"></i></button>
                            </a>
                            {{ Form::button('<i class="faw-form fas fa-trash-alt" aria-hidden="true"></i>',
                             ['class' => 'btn btn-danger btn-form', 'id'=>"delete", 'type' => 'submit']) }}
                            {!! Form::close() !!}
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    @include('layouts.modals.delete')
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
@endsection

