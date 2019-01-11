@extends('layouts.master')
@section('css')

@endsection
@section('content')

    @if(Session('created_priority_success'))
        <div class="alert alert-success">
            <strong>Success! </strong>{{Session('created_priority_success')}}
        </div>
    @elseif(Session('created_priority_failed'))
        <div class="alert alert-danger">
            <strong>Warning! </strong>{{Session('created_priority_failed')}}
        </div>
    @elseif(Session('priority_updated'))
        <div class="alert alert-success">
            <strong>Success! </strong>{{Session('priority_updated')}}
        </div>
    @elseif(Session('priority_deleted'))
        <div class="alert alert-info">
            <strong>Success! </strong>{{Session('priority_deleted')}}
        </div>
    @endif

    <h1 class="col-md-10">Priorities</h1>

    <div class="col-md-7">

        <table id="table" class="table display cell-border embed-responsive">
            <thead>
            <tr id="column-search">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Color</th>
                <th scope="col">Active</th>
                <th scope="col">Created</th>
                <th scope="col">Updated</th>
                <th scope="col">Operation</th>


            </tr>
            </thead>
            <tbody>
            @if($priorities)
                @foreach($priorities as $priority)
                    <tr>
                        <td>{{$priority->id}}</td>
                        <td>{{$priority->name}}</td>
                        <td class="circle-color"><i class="fas fa-circle" style="color:{{$priority->color}}"></i></td>
                        <td>{{$priority->is_active == 1 ? 'Active' : 'Not active'}}</td>
                        <td>{{$priority->created_at->format('d/m/Y')}}</td>
                        <td>{{$priority->updated_at->format('d/m/Y')}}</td>
                        <td><a>
                            {!! Form::model($priority, ['method' => 'delete',
                             'route' => ['priorities.destroy', $priority->id],
                              'class' =>'form-inline delete-form',
                               'data-id'=>$priority->id]) !!}
                            <a href="{{route('admin.priorities.edit', $priority->id)}}">
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

    </div>

    <div class="col-md-3">


        {!! Form::open(['method'=>'POST', 'action'=>'AdminPrioritiesController@store'])!!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('name') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('color', 'Color') !!}
            {!! Form::color('color', '#808080', ['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), 1,['class'=>'form-control'])!!}
        </div>
        <div class="form-group">
            {!! Form::submit('Create priority', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@include('layouts.modals.delete')

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>

@endsection