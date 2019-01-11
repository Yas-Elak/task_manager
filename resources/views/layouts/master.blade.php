<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">


    <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/default.css') }}">

    {{--<link rel="stylesheet" href="/css/app.css">--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ url('/css/masterstyle.css') }}"/>

    @yield('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{route('home.index')}}">Task Manager</a>
    <div id="navbarNavDropdown" class="navbar-collapse collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home.index')}}">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav">
            @if(!Auth::user())
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/register') }}">Register</a>
                </li>
            @else
                @if($notification_count['project'] > 0)
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-notif" type="button" data-toggle="dropdown">
                            <i class="fas fa-project-diagram"></i>
                            <span class="badge badge-light"> {{ $notification_count['project']}}</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($notifications as $notification)
                                @if(is_object($notification->project))
                                    <a class="dropdown-item " href="{{route('projects.show', $notification->project->id)}}">{{$notification->type}}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
                @endif
                    @if($notification_count['task'] > 0)

                    <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-notif" type="button" data-toggle="dropdown">
                            <i class="fas fa-tasks"></i>
                            <span class="badge badge-light"> {{$notification_count['task']}}</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($notifications as $notification)
                                @if(is_object($notification->task))
                                    <a class="dropdown-item " href="{{route('tasks.show', $notification->task->id)}}">{{$notification->type}}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
                @endif
                    @if($notification_count['ticket'] > 0)

                    <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-notif" type="button" data-toggle="dropdown">
                            <i class="fas fa-ticket-alt"></i>
                            <span class="badge badge-light"> {{$notification_count['ticket']}}</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($notifications as $notification)
                                @if(is_object($notification->ticket))
                                    <a class="dropdown-item " href="{{route('tickets.show', $notification->ticket->id)}}">{{$notification->type}}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
                @endif
                    @if($notification_count['comment'] > 0)

                    <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-notif" type="button" data-toggle="dropdown">
                            <i class="fas fa-comments"></i>
                            <span class="badge badge-light"> {{$notification_count['comment']}}</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($notifications as $notification)
                                @if(is_object($notification->comment))
                                    @if(is_object($notification->comment->project))
                                        <a class="dropdown-item " href="{{route('projects.show', $notification->comment->project->id)}}">{{$notification->type}}</a>
                                    @endif
                                        @if(is_object($notification->comment->task))
                                            <a class="dropdown-item " href="{{route('tasks.show', $notification->comment->task->id)}}">{{$notification->type}}</a>
                                        @endif
                                        @if(is_object($notification->comment->ticket))
                                            <a class="dropdown-item " href="{{route('tickets.show', $notification->tickets->project->id)}}">{{$notification->type}}</a>
                                        @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
                    @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show', Auth::user()->id)}}">{{Auth::User()->last_name}} <i
                                class="fas fa-user"></i></a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
            @endif
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-project-diagram"></i>
                        <p>
                            Projects
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('projects.index')}}" class="nav-link">
                                <p>All projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('projects.myassignedprojects', Auth::user()->id)}}" class="nav-link">
                                <p>My assigned projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('projects.mymanagedprojects', Auth::user()->id)}}" class="nav-link">
                                <p>My Managed projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('projects.create')}}" class="nav-link">
                                <p>Create projects</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tasks"></i>
                        <p>
                            Tasks
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('tasks.index')}}" class="nav-link">
                                <p>All tasks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tasks.mytasks', Auth::user()->id)}}" class="nav-link">
                                <p>All of my tasks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tasks.mycompletedtasks', Auth::user()->id)}}" class="nav-link">
                                <p>My completed tasks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tasks.myassignedtasks', Auth::user()->id)}}" class="nav-link">
                                <p>My assigned tasks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tasks.create')}}" class="nav-link">
                                <p>Create tasks</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-ticket-alt"></i>
                        <p>
                            Tickets
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('tickets.index')}}" class="nav-link">
                                <p>All tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tickets.createdTickets', Auth::user()->id)}}" class="nav-link">
                                <p>My Created tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tickets.assignedTickets', Auth::user()->id)}}" class="nav-link">
                                <p>My assigned tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tickets.completedTicketsAsAgent', Auth::user()->id)}}"
                               class="nav-link">
                                <p>My completed tickets (agent)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tickets.completedTicketsAsOwner', Auth::user()->id)}}"
                               class="nav-link">
                                <p>My completed tickets (owner)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tickets.create')}}" class="nav-link">
                                <p>Create tickets</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if( Auth::user()->role->name == 'Administrator' )
                    <div class="row">
                        <div class="col">
                            <hr>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-secondary" id="sidebar-admin-hide">
                                <i class="fas fa-cogs"></i> Admin menu
                            </button>
                        </div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                    <div id="admin-panel">


                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-users"></i>
                                <p>Users<i class="fa fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.users.index')}}" class="nav-link">All Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.users.create')}}" class="nav-link">Create User</a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-comments"></i>
                                <p>Comments <i class="fa fa-angle-left right"></i></p>
                                <small><span class="badge badge-secondary">{{$notification_count['comments']}}</span></small>

                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.comments.all')}}" class="nav-link">All comments</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.comments.index')}}" class="nav-link">Moderate comments</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-highlighter"></i>
                                <p>Priorities<i class="fa fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.priorities.index')}}" class="nav-link">All priorities</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Statuses<i class="fa fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.statuses.index')}}" class="nav-link">All statuses</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-exclamation-circle"></i>
                                <p>Issues<i class="fa fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.issues.index')}}" class="nav-link">All issues</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-object-ungroup"></i>
                                <p>Components<i class="fa fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.components.index')}}" class="nav-link">All components</a>
                                </li>
                            </ul>
                        </li>
                    </div>




                @endif

            </ul>
        </nav>

        {{--<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">--}}
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
            <div class="content">

                <div class="container-fluid">
                    <div class="row">

                        @yield('content')
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->

        </main>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.1/js/dataTables.colReorder.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@yield('scripts')

<script>
    $("#sidebar-admin-hide").click(function () {
        $("#admin-panel").toggle();
    });
</script>

</body>
</html>
