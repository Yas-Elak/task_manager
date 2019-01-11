<?php

namespace App\Http\Controllers;

use App\Audit;
use App\Comment;
use App\Component;
use App\Email;
use App\Http\Requests\TicketFormRequest;
use App\Notification;
use App\priority;
use App\Project;
use App\Status;
use App\Task;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('users.tickets.index', compact('tickets'));
    }

    /**
     * Get all the user's created ticket
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createdTickets()
    {
        $user = Auth::user();
        $tickets = $user->createdTickets()->get();
        return view('users.tickets.index', compact('tickets'));
    }

    /**
     * get all the ticket who are assignated to the user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignedTickets()
    {
        $user = Auth::user();
        $tickets = $user->assignedTickets()->whereHas('status', function($query){
            $query->where('name', '!=', 'Closed');
        })->get();
        return view('users.tickets.index', compact('tickets'));
    }

    /**
     * get al the completed tickets the user's created
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function completedTicketsAsOwner()
    {
        $user = Auth::user();
        $tickets = $user->completedTicketsAsOwner()->whereHas('status', function($query){
            $query->where('name', '=', 'Closed');
        })->get();
        return view('users.tickets.index', compact('tickets'));
    }

    /**
     * get al the completed tickets we assignated to the user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function completedTicketsAsAgent()
    {
        $user = Auth::user();
        $tickets = $user->completedTicketsAsAgent()->whereHas('status', function($query){
            $query->where('name', '=', 'Closed');
        })->get();
        return view('users.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('last_name','id')->all();
        $tasks = Task::pluck('subject','id')->all();
        $statuses = Status::pluck('name','id')->all();
        $projects = Project::pluck('subject','id')->all();
        $priorities = Priority::pluck('name','id')->all();
        $components = Component::pluck('name','id')->all();

        return view('users.tickets.create', compact('users','statuses', 'projects', 'priorities', 'components', 'tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketFormRequest $request)
    {
        $owner = Auth::user();

        $data = $request->all();
        $data['owner_id'] = $owner->id;

        if(Ticket::all()->count() <= 250) {

            $ticket = Ticket::create($data);
            $ticket->audits()->save(Ticket::auditTicketOperation($ticket, $owner, 'created'));

            //the send email function ask for an array an not an object, so i pass an array with the object inside
            $ticket_array = array(
                'data' => $ticket
            );
            Email::ticketMail($ticket_array, 'admin.email.newticket', "Hi you have a new ticket : ");

            Notification::create(['user_id' => $ticket->agent_id, 'ticket_id' => $ticket->id, 'type' => 'New Ticket : ' . $ticket->subject]);

            Session::flash('created_ticket_success', 'The ticket : ' . $ticket->subject . ' has been created.');
        } else {
            Session::flash('created_ticket_failed', 'You can\'t create more than 250 tickets, delete some tickets before trying again');
        }
        return redirect ('/tickets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        //todo should use relationship
        $comments = Comment::whereTicketId($id)->whereModerate(1)->get();

        Notification::whereUserId(Auth::User()->id)->where('ticket_id', $id)->delete();
        Notification::whereUserId(Auth::User()->id)->where('comment_id', $id)->delete();


        return view ('users.tickets.show', compact('ticket', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $users = User::pluck('last_name','id')->all();
        $tasks = Task::pluck('subject','id')->all();
        $statuses = Status::pluck('name','id')->all();
        $projects = Project::pluck('subject','id')->all();
        $priorities = Priority::pluck('name','id')->all();
        $components = Component::pluck('name','id')->all();

        return view('users.tickets.edit', compact('ticket','users','statuses', 'projects', 'priorities', 'components', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketFormRequest $request, $id)
    {
        $owner = Auth::user();
        $ticket = Ticket::findOrFail($id);

        $data = $request->all();
        $data['owner_id'] = $owner->id;

        $ticket->update($data);
        $ticket->audits()->save(Ticket::auditTicketOperation($ticket, $owner, 'Update :'));

        //the send email function ask for an array an not an object, so i pass an array with the object inside
        $ticket_array = array(
            'data' => $ticket
        );
        Email::ticketMail($ticket_array, 'admin.email.editticket' ,"Hi you have a update to the ticket : ");

        Notification::create(['user_id' => $ticket->agent_id, 'ticket_id' => $ticket->id, 'type' => 'Updated Ticket : ' . $ticket->subject]);

        Session::flash('ticket_updated', 'The ticket : ' . $ticket->subject .' is updated.');

        return redirect ('/tickets');
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
        $ticket = Ticket::findOrFail($id);

        $ticket->audits()->save(Ticket::auditTicketOperation($ticket, $owner, 'Deleted'));
        Session::flash('ticket_deleted', 'The ticket : ' . $ticket->subject .' is deleted.');

        $ticket->delete();

        return redirect('/tickets');
    }
}
