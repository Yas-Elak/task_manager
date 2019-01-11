@extends('layouts.master')
@section('css')
@endsection
@section('content')
    @if(Session('created_ticket_success'))
        <div class="alert alert-success">
            <strong> Success!</strong>{{Session('created_ticket_success')}}
        </div>
    @elseif(Session('created_ticket_failed'))
        <div class="alert alert-danger">
            <strong> Warning!</strong>{{Session('created_ticket_failed')}}
        </div>
    @elseif(Session('ticket_updated'))
        <div class="alert alert-success">
            <strong> Success!</strong>{{Session('ticket_updated')}}
        </div>
    @elseif(Session('ticket_deleted'))
        <div class="alert alert-info">
            <strong> Success!</strong>{{Session('ticket_deleted')}}
        </div>
    @endif
    <h1 class="col-md-10">Tickets</h1>
    <table id="table" class="table display cell-border embed-responsive">
        <thead>
        <tr id="column-search">
            <th scope="col">ID</th>
            <th scope="col">Subject</th>
            <th scope="col">Project</th>
            <th scope="col">Task</th>
            <th scope="col">Creator</th>
            <th scope="col">Agent</th>
            <th scope="col">Status</th>
            <th scope="col">Priority</th>
            <th scope="col">Component</th>
            <th scope="col">Active</th>
            <th scope="col">Created</th>
            <th scope="col">Updated</th>
            <th scope="col">Operations</th>

        </tr>
        </thead>
        <tbody>
        @if($tickets)
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{$ticket->id}}</td>
                    <td><a href="{{route('tickets.show', $ticket->id)}}">{{$ticket->subject}}</a></td>
                    <td>@if(!empty($ticket->project))
                            {{$ticket->project->subject}}
                        @endif
                    </td>
                    <td>@if(!empty($ticket->task))
                            {{$ticket->task->subject}}
                        @endif
                    </td>
                    <td>{{$ticket->owner->last_name}}</td>
                    <td>{{$ticket->agent->last_name}}</td>
                    <td><span class="td-status badge badge-pill"
                              style="background-color:{{$ticket->status->color}}">{{$ticket->status->name}}</span></td>
                    <td><span class="td-priority badge badge-pill"
                              style="background-color:{{$ticket->priority->color}}">{{$ticket->priority->name}}</span>
                    </td>
                    <td>@if(!empty($ticket->component))
                            {{$ticket->component->name}}
                        @endif
                    </td>
                    <td>{{$ticket->is_active == 1 ? 'Active' : 'Not active'}}</td>
                    <td>{{$ticket->created_at->format('d/m/Y')}}</td>
                    <td>{{$ticket->updated_at->format('d/m/Y')}}</td>
                    @if( Auth::user()->isAdmin() OR Auth::user()->isAdmin() OR Auth::user()->id == $ticket->owner_id)
                        <td>
                            <a>
                                {!! Form::model($ticket, ['method' => 'delete',
                                 'route' => ['tickets.destroy', $ticket->id],
                                  'class' =>'form-inline delete-form',
                                   'data-id'=>$ticket->id]) !!}
                                <a href="{{route('tickets.edit', $ticket->id)}}">
                                    <button type="button" class="btn btn-info edit-item btn-form" }><i
                                                class="faw-form fas fa-edit"></i></button>
                                </a>
                                {{ Form::button('<i class="faw-form fas fa-trash-alt" aria-hidden="true"></i>',
                                 ['class' => 'btn btn-danger btn-form', 'id'=>"delete", 'type' => 'submit']) }}
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