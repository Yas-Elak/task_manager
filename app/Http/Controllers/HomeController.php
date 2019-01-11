<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Project;
use App\Status;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * Pass the data to show some tasks and charts on the dashboard
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //General data for charts
        $user = Auth::user();
        $statuses =  Status::all();

        //data for chart who show the status of your project
        $project_array = array();
        foreach ($statuses as $status){
            $project_array[$status->name] = Project::countUserProjectBy('status', $user, $status->name);
        }

        //data for charts who show the status of your task
        $task_array = array();
        foreach ($statuses as $status){
            $task_array[$status->name] = Task::countUserTaskBy('status', $user ,$status->name);
        }

        //data for charts who show your task against your project's task
        $all_your_projects = $user->projects()->get();

        //get all the tasks of the auth user who must be finish in the next week and not late
        $this_week_tasks =  Auth::User()->tasks()->get()->where('wanted_end_datetime', '<', Carbon::now()->endOfWeek())
            ->where('wanted_end_datetime', '>', Carbon::now()->startOfWeek());

        //get all the tasks of the auth user who should who should be done but are still open
        $too_late_tasks = Auth::User()->tasks()->get()->where('wanted_end_datetime', '<', Carbon::now());

        return view('home', compact( 'project_array', 'task_array', 'statuses', 'all_your_projects', 'this_week_tasks', 'too_late_tasks'));
    }
}
