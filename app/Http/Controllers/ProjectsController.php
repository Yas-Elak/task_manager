<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Email;
use App\Http\Requests\ProjectFormRequest;
use App\Notification;
use App\priority;
use App\Project;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('users.projects.index', compact('projects'));
    }

    /**
     *Only return the project in who were assignated to the user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myAssignedProjects()
    {
        $user = Auth::user();
        $projects = $user->projects()->get();
        return view('users.projects.index', compact('projects'));
    }

    /**
     *Only return the project the user manage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myManagedProjects()
    {
        $user = Auth::user();
        $projects = Project::whereManagerId($user->id)->get();
        return view('users.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('last_name','id')->all();
        $statuses = Status::pluck('name','id')->all();
        $priorities = Priority::pluck('name','id')->all();
        return view('users.projects.create', compact('users', 'statuses', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectFormRequest $request)
    {
        $owner = Auth::user();

        $data = $request->all();
        if(Project::all()->count() <= 50){
            $project = Project::create($data);
            //For pivot table who will give me each project on which the user participate
            $project->users()->attach($request->user_id);
            //Save the audit with a method to concatenate the informations
            $project->audits()->save(Project::auditProjectOperation($project, $owner, 'created'));
            //the send email function ask for an array an not an object, so i pass an array with the object inside
            $project_array = array(
                'data' => $project
            );
            Email::projectMail($project_array, 'admin.email.newproject' ,"Hi you have a new project: ");
            //notifications
            foreach ($project->users()->get() as $user){
                Notification::create(['user_id' => $user->id, 'project_id' => $project->id, 'type' => 'New Project : ' . $project->subject]);
            }
            Session::flash('created_project_success', 'The project : ' . $project->subject . ' has been created.');
        } else {
            Session::flash('created_project_failed', 'You can\'t create more than 50 projects, delete some projects before trying again');
        }

        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        //todo should use relationship
        $comments = Comment::whereProjectId($id)->whereModerate(1)->get();

        Notification::whereUserId(Auth::User()->id)->where('project_id', $id)->delete();
        Notification::whereUserId(Auth::User()->id)->where('comment_id', $id)->delete();

        return view ('users.projects.show', compact('project', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $users = User::all()->pluck('last_name', 'id');
        $project = Project::findOrFail($id);
        $statuses = Status::pluck('name','id')->all();
        $priorities = Priority::pluck('name','id')->all();
        $selected_users = $project->users->pluck('id');
        return view('users.projects.edit', compact('project', 'users', 'statuses', 'priorities', 'selected_users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectFormRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $owner = Auth::user();

        $data = $request->all();

        $project->update($data);
        $project->users()->attach($request->user_id);
        $project->audits()->save(Project::auditProjectOperation($project, $owner, 'Updated'));

        //the send email function ask for an array an not an object, so i pass an array with the object inside
        $project_array = array(
            'data' => $project
        );
        Email::projectMail($project_array, 'admin.email.editproject' ,"Hi you have a update to the project : ");

        foreach ($project->users()->get() as $user){
            Notification::create(['user_id' => $user->id, 'project_id' => $project->id, 'type' => 'Updated Project : ' . $project->subject]);
        }

        Session::flash('project_updated', 'The project : ' . $project->subject .' is updated.');

        return redirect('/projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $owner = Auth::user();
        $project = Project::findOrFail($id);

        $project->audits()->save(Project::auditProjectOperation($project, $owner, 'Deleted'));
        Session::flash('project_deleted', 'The project : ' . $project->subject .' is deleted.');

        $project->delete();

        return redirect('/projects');
    }
}
