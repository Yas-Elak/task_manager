<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin', function () {
        return view('admin.index');
    });

    Route::resource('admin/users', 'AdminUsersController', ['names' => [
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'destroy' => 'admin.users.destroy',

    ]]);

    Route::resource('admin/priorities', 'AdminPrioritiesController', ['names' => [
        'index' => 'admin.priorities.index',
        'create' => 'admin.priorities.create',
        'store' => 'admin.priorities.store',
        'edit' => 'admin.priorities.edit'
    ]]);

    Route::resource('admin/statuses', 'AdminStatusesController', ['names' => [
        'index' => 'admin.statuses.index',
        'create' => 'admin.statuses.create',
        'store' => 'admin.statuses.store',
        'edit' => 'admin.statuses.edit'
    ]]);
    Route::resource('admin/projects', 'AdminProjectsController', ['names' => [
        'index' => 'admin.projects.index',
        'create' => 'admin.projects.create',
        'store' => 'admin.projects.store',
        'edit' => 'admin.projects.edit'
    ]]);
    Route::resource('admin/issues', 'AdminIssuesController', ['names' => [
        'index' => 'admin.issues.index',
        'create' => 'admin.issues.create',
        'store' => 'admin.issues.store',
        'edit' => 'admin.issues.edit'
    ]]);
    Route::resource('admin/components', 'AdminComponentsController', ['names' => [
        'index' => 'admin.components.index',
        'create' => 'admin.components.create',
        'store' => 'admin.components.store',
        'edit' => 'admin.components.edit'
    ]]);

    Route::resource('admin/tasks', 'AdminTasksController', ['names' => [
        'index' => 'admin.tasks.index',
        'create' => 'admin.tasks.create',
        'store' => 'admin.tasks.store',
        'edit' => 'admin.tasks.edit'
    ]]);
    Route::get('admin/comments/all', 'CommentsController@allComments')->name('admin.comments.all');
    Route::resource('admin/comments', 'CommentsController', ['names' => [
        'index' => 'admin.comments.index',
        'create' => 'admin.comments.create',
        'store' => 'admin.comments.store',
        'edit' => 'admin.comments.edit',
        'show' => 'admin.comments.show',

    ]]);
});

Route::get('home', 'HomeController@index')->name('home.index');

//custom route must be add before
Route::get('tasks/{user}/all', 'TasksController@myTasks')->name('tasks.mytasks');
Route::get('tasks/{user}/assigned', 'TasksController@myAssignedTasks')->name('tasks.myassignedtasks');
Route::get('tasks/{user}/completed', 'TasksController@myCompletedTasks')->name('tasks.mycompletedtasks');
Route::get('tasks/{project}/opentask', 'TasksController@projectOpenTasks')->name('tasks.projectopentasks');
Route::get('tasks/{project}/closedtask', 'TasksController@projectClosedTasks')->name('tasks.projectclosedtasks');

Route::resource('tasks', 'TasksController', ['names' => [
    'index' => 'tasks.index',
    'create' => 'tasks.create',
    'store' => 'tasks.store',
    'edit' => 'tasks.edit'
]]);

Route::get('projects/{user}/assigned', 'ProjectsController@myAssignedProjects')->name('projects.myassignedprojects');
Route::get('projects/{user}/managed', 'ProjectsController@myManagedProjects')->name('projects.mymanagedprojects');

    Route::resource('projects', 'ProjectsController', ['names' => [
//        'index' => 'projects.index',
        'create' => 'projects.create',
        'store' => 'projects.store',
        'edit' => 'projects.edit',
//        'show' => 'projects.show'

    ]]);



Route::get('tickets/{user}/mycreatedticket', 'TicketsController@createdTickets')->name('tickets.createdTickets');
Route::get('tickets/{user}/ownerassignedticket', 'TicketsController@assignedTickets')->name('tickets.assignedTickets');
Route::get('tickets/{user}/agentcompleted', 'TicketsController@completedTicketsAsAgent')->name('tickets.completedTicketsAsAgent');
Route::get('tickets/{user}/ownercompleted', 'TicketsController@completedTicketsAsOwner')->name('tickets.completedTicketsAsOwner');
Route::resource('tickets', 'TicketsController', ['names' => [
    'index' => 'tickets.index',
    'create' => 'tickets.create',
    'store' => 'tickets.store',
    'edit' => 'tickets.edit',
    'show' => 'tickets.show'

]]);

Route::resource('users', 'UsersController', ['names' => [
    'index' => 'users.index',
    'edit' => 'users.edit',
    'show' => 'users.show'
]]);

Route::resource('options', 'OptionsController', ['names' => [
    'index' => 'options.index',
    'store' => 'options.store',
    'edit' => 'options.edit',

]]);