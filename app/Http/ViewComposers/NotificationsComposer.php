<?php
/**
 * Created by PhpStorm.
 * User: Yassine
 * Date: 06-01-19
 * Time: 16:50
 */

namespace App\Http\ViewComposers;


use App\Comment;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationsComposer
{

    /**
     * This composer pass theses variables on all the view, Now I can have the notification on every page
     * @param View $view
     */
    public function compose(View $view){
        $notifications =  Notification::whereUserId([Auth::user()->id])->get();

        $notification_count = array(
            'project' => Auth::user()->option->project_notification == 1 ?
                Notification::where([['user_id', '=', Auth::user()->id],['project_id', '>', 0]])->count() : 0,
            'task' => Auth::user()->option->task_notification == 1 ?
                Notification::where([['user_id', '=', Auth::user()->id],['task_id', '>', 0]])->count() : 0,
            'ticket' => Auth::user()->option->project_notification == 1 ?
                Notification::where([['user_id', '=', Auth::user()->id],['ticket_id', '>', 0]])->count() : 0,
            'comment' => Auth::user()->option->project_notification == 1 ?
                Notification::where([['user_id', '=', Auth::user()->id],['comment_id', '>', 0]])->count() :0,
            'comments' => Comment::where([['moderate', '=', 0]])->count()
        );

        $view->with('notification_count', $notification_count)->with('notifications', $notifications);

    }
}