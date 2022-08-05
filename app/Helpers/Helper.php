<?php
use \Illuminate\Support\Facades\Auth;
use Pusher\Pusher;


//Day la noi khai bao cac ham helper (do minh tu tao ra)
function isAdmin(){
    if (!Auth::check()){
        return false;
    }
    if (Auth::user()->isAdmin){
        return true;
    }
    return false;
}

function url_after_login(){ //redirect
    if (isAdmin()){
        return "/admin/students-list";
    }
    return "/about";
}

//notify user: alert add student
function notify_user($channel, $event, $data){
    $options = array(
        'cluster'=>env("PUSHER_APP_CLUSTER"),
        'useTLS'=>true
    );
    $pusher = new Pusher(
        env("PUSHER_APP_KEY"),
        env("PUSHER_APP_SECRET"),
        env("PUSHER_APP_ID"),
        $options,
    );

    $pusher->trigger($channel, $event, $data);
}

