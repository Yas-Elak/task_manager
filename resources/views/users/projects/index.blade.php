@extends('layouts.master')
@section('css')
@endsection
@section('content')

        @if(Session('created_project_success'))
            <div class="alert alert-success">
                <strong>Success! </strong>{{Session('created_project_success')}}
            </div>
        @elseif(Session('created_project_failed'))
            <div class="alert alert-danger">
                <strong>Warning! </strong>{{Session('created_project_failed')}}
            </div>
        @elseif(Session('project_updated'))
            <div class="alert alert-success">
                <strong>Success! </strong>{{Session('project_updated')}}
            </div>
        @elseif(Session('project_deleted'))
            <div class="alert alert-info">
                <strong>Success! </strong>{{Session('project_deleted')}}
            </div>
        @endif
    <h1 class="col-md-10">Projects</h1>
    <table id="table" class="table display cell-border embed-responsive">
        <thead>
        <tr id="column-search">
            <th scope="col">ID</th>
            <th scope="col">Subject</th>
            <th scope="col">Manager</th>
            <th scope="col">Manager Email</th>
            <th scope="col">Status</th>
            <th scope="col">Priority</th>
            <th scope="col">Open Tasks</th>
            <th scope="col">Closed Task</th>
            <th scope="col">Created</th>
            <th scope="col">Updated</th>
            <th scope="col">Activated</th>
            <th scope="col">Operations</th>
        </tr>
        </thead>
        <tbody>
        @if($projects)
            @foreach($projects as $project)
                <tr>
                    <td>{{$project->id}}</td>
                    <td><a href="{{route('projects.show', $project->id)}}">{{$project->subject}}</a>
                    <td>{{$project->user->last_name}}</td>
                    <td>{{$project->user->email}}</td>
                    <td><span class="td-status badge badge-pill" style="background-color:{{$project->status->color}}">{{$project->status->name}}</span></td>
                    <td><span class="td-priority badge badge-pill" style="background-color:{{$project->priority->color}}">{{$project->priority->name}}</span></td>
                    <td>
                        <a href="{{route('tasks.projectopentasks', $project->id)}}"> {{$project->tasks->where('status_id', 1)->count()}}</a>
                    </td>
                    <td>
                        <a href="{{route('tasks.projectclosedtasks', $project->id)}}"> {{$project->tasks->where('status_id', 2)->count()}}</a>
                    </td>
                    <td>{{$project->created_at->format('d/m/Y')}}</td>
                    <td>{{$project->updated_at->format('d/m/Y')}}</td>
                    <td>{{$project->is_active == 1 ? 'Active' : 'Not active'}}</td>
                    @if( Auth::user()->isAdmin() OR Auth::user()->isAdmin() OR Auth::user()->id == $project->manager_id)
                        <td>
                            <a>
                                {!! Form::model($project, ['method' => 'delete',
                                 'route' => ['projects.destroy', $project->id],
                                  'class' =>'form-inline delete-form',
                                   'data-id'=>$project->id]) !!}
                                <a href="{{route('projects.edit', $project->id)}}">
                                    <button type="button" class="btn btn-info edit-item btn-form" }><i
                                                class="faw-form fas fa-edit"></i></button>
                                </a>
                                {{ Form::button('<i class="faw-form fas fa-trash-alt" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-form', 'id'=>"delete", 'type' => 'submit']) }}
                                {!! Form::close() !!}
                            </a>
                        </td>
                        @else
                        <td>None</td>
                    @endif
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