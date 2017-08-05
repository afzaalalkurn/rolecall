<?php

namespace frontend\event;

class AutoEvent {

    public $status;
    public $id;
    public $user_id;

    public static function generate($status, $id, $config = []){

        $object             = new AutoEvent;
        $object->status     = $status;
        $object->id         = $id;
        return ( new NotificationEvent($object) );
    }

    public static function getNotify($status, $id, $user_id, $config = []){

        $object             = new AutoEvent;
        $object->status     = $status;
        $object->id         = $id;
        $object->user_id    = $user_id;
        return ( new NotificationEvent($object) );
    }

    public static function getNotifyMessage($status,$id, $msg_id, $config = []){

        $object             = new AutoEvent;
        $object->id         = $id;
        $object->msg_id    = $msg_id;
        $object->status     = $status;
        return ( new NotificationEvent($object) );
    }
}



