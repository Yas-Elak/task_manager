<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Email;
use App\Http\Requests\CommentFormRequest;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller
{
    /**
     * Display a listing of the comment who are not moderate yet
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::whereModerate(0)->get();
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * get all the comments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allComments()
    {
        $comments = Comment::all();
        return view('admin.comments.index', compact('comments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['moderate'] = 0;

        $comment = Comment::create($data);

        //creation of an array to pass in the Notification email
        $comment_array = array(
            'data' => $comment,
            'project' => $comment->project,
            'task' => $comment->task,
            'ticket' => $comment->ticket
        );
        Email::commentMail($comment_array, 'admin.email.newcomment' ,"Hi you have a new comment on : ");

        Session::flash('comment_message_success', 'Your message has been submitted and waiting moderation');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * A comment can be for a project, a task, or a ticket, to avoid error I need to check for which one it is
     * before the notifications. The  I'll notifiate all users who are part of the project/task/ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Comment::findOrFail($id)->update($request->all());


        $comment = Comment::findOrFail($id);
        if ($request->input('moderate') == 1){
            if($comment->project){
                foreach ($comment->project->users()->get() as $user){
                    Notification::create(['user_id' => $user->id, 'comment_id' => $comment->project->id, 'type' => 'New Comment on Project : ' . $comment->project->subject]);
                }
            }else if ($comment->task){
                foreach ($comment->task->users()->get() as $user){
                    Notification::create(['user_id' => $user->id, 'comment_id' => $comment->task->id, 'type' => 'New Comment on Task : ' . $comment->task->subject]);
                }
            }else if ($comment->ticket){
                Notification::create(['user_id' => $comment->ticket->agent_id, 'ticket_id' => $comment->ticket->id, 'type' => 'New comment on Ticket : ' . $comment->ticket->subject]);
            }

        };
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return redirect()->back();
    }
}
