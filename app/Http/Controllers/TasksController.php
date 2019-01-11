<?php

namespace App\Http\Controllers;

use App\Component;
use App\Email;
use App\Http\Requests\TaskFormRequest;
use App\Notification;
use App\priority;
use App\Project;
use App\Status;
use App\Task;
use App\Comment;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    /**
     * Display a listing of all the tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('users.tasks.index', compact('tasks'));
    }

    /**
     * Only return the users task the user created
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myTasks()
    {
        $user = Auth::user();
        $tasks = Task::whereOwnerId($user->id)->get();
        return view('users.tasks.index', compact('tasks'));
    }

    /**
     * Only return the users task who are assignated to the user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myAssignedTasks()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->get();
        return view('users.tasks.index', compact('tasks'));
    }


    /**
     * Only return the user's completed task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myCompletedTasks()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->whereHas('status', function($query){
            $query->where('name', '=', 'Closed');
        })->get();
        return view('users.tasks.index', compact('tasks'));
    }

    /**
     * We get the opened tasks of the project in param
     * @param $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projectOpenTasks($projectId)
    {
        $tasks = Task::whereProjectId($projectId)->whereHas('status', function($query){
            $query->where('name', '!=', 'Closed');
        })->get();
        return view('users.tasks.index', compact('tasks'));
    }

    /**
     * We get the closed tasks of the project in param
     * @param $projectId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projectClosedTasks($projectId)
    {
        $tasks = Task::whereProjectId($projectId)->whereHas('status', function($query){
            $query->where('name', '=', 'Closed');
        })->get();
        return view('users.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('last_name','id')->all();
        $projects = Project::pluck('subject','id')->all();
        $statuses = Status::pluck('name','id')->all();
        $priorities = Priority::pluck('name','id')->all();

        return view('users.tasks.create', compact('users','statuses', 'projects', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskFormRequest $request)
    {
        $owner = Auth::user();

        $data = $request->all();
        $data['owner_id'] = $owner->id;
        if(Task::all()->count() <= 250) {
            $task = Task::create($data);
            $task->users()->attach($request->user_id);
            $task->audits()->save(Task::auditTaskOperation($task, $owner, 'created'));
            //the send email function ask for an array an not an object, so i pass an array with the object inside
            $task_array = array(
                'data' => $task
            );
            Email::taskMail($task_array, 'admin.email.newtask', "Hi you have a new task : ");
            //Notification get all user of the task and create an entry in the notification table for each
            foreach ($task->users()->get() as $user) {
                Notification::create(['user_id' => $user->id, 'task_id' => $task->id, 'type' => 'New Task : ' . $task->subject]);
            }
            Session::flash('created_task_success', 'The project : ' . $task->subject . ' has been created.');
        } else {
            Session::flash('created_task_failed', 'You can\'t create more than 250 tasks, delete some tasks before trying again');
        }

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        //todo should use relationship
        $comments = Comment::whereTaskId($id)->whereModerate(1)->get();

        Notification::whereUserId(Auth::User()->id)->where('task_id', $id)->delete();
        Notification::whereUserId(Auth::User()->id)->where('comment_id', $id)->delete();

        return view ('users.tasks.show', compact('task', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        $users = User::pluck('last_name','id')->all();
        $statuses = Status::pluck('name','id')->all();
        $projects = Project::pluck('subject','id')->all();
        $priorities = Priority::pluck('name','id')->all();
        $selected_users = $task->users->pluck('id');

        return view('users.tasks.edit', compact('task','users','statuses', 'projects', 'priorities', 'components', 'selected_users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskFormRequest $request, $id)
    {

        $owner = Auth::user();
        $task = Task::findOrFail($id);

        $data = $request->all();
        $data['owner_id'] = $owner->id;
        $task->update($data);
        $task->audits()->save(Task::auditTaskOperation($task, $owner, 'updated'));

        //the send email function ask for an array an not an object, so i pass an array with the object inside
        $task_array = array(
            'data' => $task
        );
        Email::taskMail($task_array, 'admin.email.edittask' ,"Hi you have a update to the task : ");

        //Notification get all user of the task and create an entry in the notification table for each
        foreach ($task->users()->get() as $user){
            Notification::create(['user_id' => $user->id, 'task_id' => $task->id, 'type' => 'Updated Task : ' . $task->subject]);
        }

        Session::flash('task_updated', 'The task : ' . $task->subject .' is updated.');

        return redirect ('/tasks');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $owner = Auth::user();
        $task = Task::findOrFail($id);

        $task->audits()->save(Task::auditTaskOperation($task, $owner, 'Deleted'));
        Session::flash('task_deleted', 'The task : ' . $task->subject .' is deleted.');

        $task->delete();

        return redirect('/tasks');
    }
}
