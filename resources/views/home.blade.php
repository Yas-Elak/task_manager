@extends('layouts.master')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Your tasks due this week</div>
                    <div>
                        <div class="list-group" id="user-info">
                            <div class="clearfix split-items">
                                @foreach($this_week_tasks as $task)
                                    @if($task->status->name != 'Closed' OR $task->status->name != 'Done')
                                        <a href="{{route('tasks.show', $task->id)}}"><p  class="list-group-item left-side-task">{{$task->subject}}</p></a>
                                        <p  class="list-group-item right-side-task ">{{$task->wanted_end_datetime->format('d-m-Y')}}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Your are late on these tasks</div>
                    <div>
                        <div class="list-group" id="user-info">
                            <div class="clearfix split-items">
                                @foreach($too_late_tasks as $task)
                                    @if($task->status->name != 'Closed' OR $task->status->name != 'Done')
                                        <a href="{{route('tasks.show', $task->id)}}"><p  class="list-group-item left-side-task">{{$task->subject}}</p></a>
                                        <p  class="list-group-item right-side-task ">{{$task->wanted_end_datetime->format('d-m-Y')}}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">My task by statuses</div>
                    <div>
                        <canvas id="myTaskChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">My project by statuses</div>
                    <div>
                        <canvas id="myProjectChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Projects tasks / your tasks</div>
                    <div>
                        <canvas id="bar-chart-grouped"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myTaskChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($statuses as $status)
                        "{{$status->name}}",
                    @endforeach
                ], datasets: [{
                    backgroundColor: [
                        @foreach($statuses as $status)
                            "{{$status->color}}",
                        @endforeach

                    ],
                    data: [
                        @foreach($task_array as $task)
                            "{{$task}}",
                        @endforeach
                    ]
                }]
            }
        });
    </script>

    <script>
        var ctx = document.getElementById("myProjectChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($statuses as $status)
                        "{{$status->name}}",
                    @endforeach
                ], datasets: [{
                    backgroundColor: [
                        @foreach($statuses as $status)
                            "{{$status->color}}",
                        @endforeach

                    ],
                    data: [
                        @foreach($project_array as $project)
                            "{{$project}}",
                        @endforeach
                    ]
                }]
            }
        });
    </script>

    <script>
        var ctx = document.getElementById("myProjectChart").getContext('2d');
        var myChart = new Chart(document.getElementById("bar-chart-grouped"), {
            type: 'bar',
            data: {
                labels: [
                    @foreach($all_your_projects as $project)
                        "{{$project->subject}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: "Project",
                        backgroundColor: "#3e95cd",
                        data: [@foreach($all_your_projects as $project)
                            "{{count($project->tasks()->get())}}",
                            @endforeach]

                    }, {
                        label: "Task",
                        backgroundColor: "#8e5ea2",
                        data: [@foreach($all_your_projects as $project)
                                    "{{count(Auth::User()->tasks()->get()->where('project_id', "=", $project->id))}}",
                               @endforeach]
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                title: {
                    display: false,
                    text: 'The project tasks / Your tasks'
                }
            }
        });
    </script>

@endsection
