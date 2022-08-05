<?php

namespace App\Listeners;

use App\Events\CreateAStudent;
use App\Events\NotifyUser;
use App\Mail\MailFromAdmin;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Pusher\Pusher;

class NotificationCreateStudent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CreateAStudent  $event
     * @return void
     */
    public function handle(CreateAStudent $event)
    {
        //description
        $message = Auth::user()->name.' vừa thêm sinh viên '. $event->_student->studentName //name user, name student
                . ' vào lớp ' . $event->_student->getClasses->className;   //name class->func getClasses
        //create
        $nt = Notification::create([
                'title'=>'Add a new student',
                'description'=>$message,
        ]);

        Cache::forget('home_data'); //xoa 1 cache, su kien chi dung 1 lan
        //Cache::flush();   //xoa tat ca

        //truyen vao func notify_user() tu helper
        notify_user('my-channel', 'my-event', $nt->toJson());

        //send mail
        Mail::to("nxuanthao03@gmail.com")
            ->send(new MailFromAdmin($event->_student));
    }
}
