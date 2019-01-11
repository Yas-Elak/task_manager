<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Email extends Model
{

    /**
     * Send the email when a task is created/updated/deleted
     *
     * @param $data
     * @param $route
     * @param $subject
     */
    public static function taskMail($data, $route, $subject)
    {
        //still must change the message to because if i do user>email it returns an error 400 form mailgun
        //with mail gun i can send email to authorize adress only with the free account
        //here I only have mine so i just leave it like that for now
        foreach ($data['data']->users()->get() as $user) {
            if ($user->option->task_email == 15) {
                Mail::send($route, $data, function ($message) use ($data, $user, $subject) {
                    $message->to('elalaoui87@gmail.com')->subject($subject . $data['data']->subject);
                });
            }
        }
    }

    /**
     * Send the email when a ticket is created/updated/deleted
     * @param $data
     * @param $route
     * @param $subject
     */
    public static function ticketMail($data, $route, $subject)
    {
//        $message->to($data['data']->agent->email)->subject($subject . $data['data']->subject);
        if ($data['data']->agent->option->ticket_email == 5) {
            Mail::send($route, $data, function ($message) use ($data, $subject) {
                $message->to('elalaoui87@gmail.com')->subject($subject . $data['data']->subject);
            });
        }
    }

    /**
     * Send the email when a project is created/updated/deleted
     *
     * @param $data
     * @param $route
     * @param $subject
     */
    public static function projectMail($data, $route, $subject)
    {
        //still must change the message to because if i do user>email it returns an error 400 form mailgun
        foreach ($data['data']->users()->get() as $user) {
            if ($user->option->project_email == 199) {
                Mail::send($route, $data, function ($message) use ($data, $user, $subject) {
                    $message->to('elalaoui87@gmail.com')->subject($subject . $data['data']->subject);
                });
            }
        }
    }

    /**
     * Send the email when a comment is created
     *
     * @param $data
     * @param $route
     * @param $subject
     */
    public static function commentMail($data, $route, $subject)
    {
        //the project, the ticket and the task are nullable so I must check which one the comment is for before
        //sending the email
        if (!empty($data['project'])) {
            foreach ($data['project']->users()->get() as $user) {
                if ($user->option->comment_email == 120) {
                    Mail::send($route, $data, function ($message) use ($data, $subject) {
                        $message->to('elalaoui87@gmail.com')->subject($subject . $data['project']->subject);
                    });
                }
            }
        } else if (!empty($data['task'])) {
            foreach ($data['task']->users()->get() as $user) {
                if ($user->option->comment_email == 5) {
                    Mail::send($route, $data, function ($message) use ($data, $subject) {
                        $message->to('elalaoui87@gmail.com')->subject($subject . $data['task']->project->subject);
                    });
                }
            }
        } else if (!empty($data['ticket'])) {
            if ($data['data']->agent->option->ticket_email == 5) {
                Mail::send($route, $data, function ($message) use ($data, $subject) {
                    $message->to('elalaoui87@gmail.com')->subject($subject . $data['ticket']->project->subject);
                });
            }
        }
    }
}
