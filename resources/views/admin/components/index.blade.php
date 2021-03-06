@extends('layouts.master')
@section('css')
@endsection
@section('content')

    @if(Session('created_component_success'))
        <div class="alert alert-success">
            <strong>Success! </strong>{{Session('created_component_success')}}
        </div>
    @elseif(Session('created_component_failed'))
        <div class="alert alert-danger">
            <strong>Warning! </strong>{{Session('created_component_failed')}}
        </div>
    @elseif(Session('component_updated'))
        <div class="alert alert-success">
            <strong>Success! </strong>{{Session('component_updated')}}
        </div>
    @elseif(Session('component_deleted'))
        <div class="alert alert-info">
            <strong>Success! </strong>{{Session('component_deleted')}}
        </div>
    @endif
    <h1 class="col-md-10">Components</h1>

    <div class="col-md-7">
        <table id="table" class="table display cell-border embed-responsive">
            <thead>
            <tr id="column-search">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Active</th>
                <th scope="col">Created</th>
                <th scope="col">Updated</th>
                <th scope="col">Operation</th>
            </tr>
            </thead>
            <tbody>
            @if($components)
                @foreach($components as $component)
                    <tr>
                        <td>{{$component->id}}</td>
                        <td>{{$component->name}}</td>
                        <td>{{$component->is_active == 1 ? 'Active' : 'Not active'}}</td>
                        <td>{{$component->created_at->format('d/m/Y')}}</td>
                        <td>{{$component->updated_at->format('d/m/Y')}}</td>
                        <td>
                            <a>
                                {!! Form::model($component, ['method' => 'delete',
                                 'route' => ['components.destroy', $component->id],
                                  'class' =>'form-inline delete-form',
                                   'data-id'=>$component->id]) !!}
                                <a href="{{route('admin.components.edit', $component->id)}}">
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
        {!! Form::open(['method'=>'POST', 'action'=>'AdminComponentsController@store'])!!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control'])!!}
            <span class="text-danger">{{ $errors->first('name') }}</span>
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active',array(1=>'Active',0=>'Not Active'), 1,['class'=>'form-control'])!!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create component', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@include('layouts.modals.delete')

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
@endsection