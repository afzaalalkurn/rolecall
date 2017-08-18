<?php

namespace frontend\event;

use Yii;
use yii\base\Component;
use frontend\event\NotificationEvent;
use backend\modules\job\models\JobItem;
use backend\modules\user\models\UserNotification;
use backend\modules\user\models\UserNotificationRecipients;
use backend\modules\user\models\UserProfile;
use backend\modules\user\models\User;
use backend\modules\user\models\UserMsg;

class Notification extends Component{

    public static function handler(NotificationEvent $event){

        $model = new UserNotification();
        $modelJobItem = JobItem::findOne( $event->id );
        $modelProfile = Yii::$app->user->identity->userProfile;
        $role = Yii::$app->user->identity->getRoleName();

        $user_name 		= $modelProfile->getName();
        $user_name      = ucwords($user_name);
        $job_name 		= $modelJobItem->name;
        $job_id 		= $modelJobItem->job_id;
        $owner_id 		= $modelJobItem->user_id;
        $user_id 		= Yii::$app->user->getId();

        $user_mapper_id   = $event->user_id ? $event->user_id : null;
        if($user_mapper_id) {
            $modelUser = User::findOne($user_mapper_id);
            $modelUserProfile = $modelUser->userProfile;
            $recipient_name = $modelUserProfile->getName();
            $recipient_name = ucwords($recipient_name);
        }
        $msg_id   = $event->msg_id ? $event->msg_id : null;

        if($msg_id){
            $modelMessage = UserMsg::findOne($msg_id);
            $recipient_id_msg = $modelMessage->user_id;
            $modelUser = User::findOne($recipient_id_msg);
            $modelUserProfile = $modelUser->userProfile;
            $recipient_name_msg = $modelUserProfile->getName();
            $recipient_name_msg = ucwords($recipient_name_msg);
        }

        if($event->status) {
            switch($event->status){
                case NotificationEvent::NOTIFICATION_JOB :
                    $action_text = sprintf('posted %s', $event->status);
                    break;
                case NotificationEvent::NOTIFICATION_JOB_UPDATE :
                    $action_text = sprintf('%s', $event->status);
                    break;
                case NotificationEvent::NOTIFICATION_FAVORITE:
                    $action_text = sprintf('marked as %s', $event->status);
                    break;
                case NotificationEvent::NOTIFICATION_SEND:
                    $action_text = sprintf('sent as %s', $event->status);
                    break;
                default:
                    $action_text = $event->status;
            }
        }

        if($user_mapper_id){
            if($role == "Director")
            {
                $textSender = sprintf("You have %s %s for %s ", $action_text, $recipient_name, $job_name );
                $textRecipient = sprintf("%s has %s you for %s ", $user_name, $action_text, $job_name );
                $recipient_id = $user_mapper_id;
            }

            else if($role == "User"){
                $textSender = sprintf("You have %s request for %s ", $action_text, $job_name);
                $textRecipient = sprintf("%s has %s your request for %s ", $user_name, $action_text, $job_name );
                $recipient_id = $owner_id;
            }

            $category = 'Email';
            $model = self::addNotification($user_id, $job_id, $category,$textSender, NotificationEvent::STATUS_READ);
            $model = self::addNotification($user_id, $job_id, $category,$textRecipient, NotificationEvent::STATUS_UNREAD);

            if($model){
                self::addRecipients($model, $user_id, NotificationEvent::STATUS_READ);
                self::addRecipients($model, $recipient_id, NotificationEvent::STATUS_UNREAD);
            }

        } else if( $msg_id ){

            $textSender = sprintf("Your message sent to %s", $recipient_name_msg );
            $textRecipient = sprintf("You have a new message from %s", $user_name );
            $category = 'Notification';
            $model = self::addNotification($user_id, $job_id, $category,$textSender, NotificationEvent::STATUS_READ);
            $model = self::addNotification($user_id, $job_id, $category,$textRecipient, NotificationEvent::STATUS_UNREAD);

            if($role == "Director"){ $recipient_id = $recipient_id_msg; }
            else if($role == "User"){$recipient_id = $owner_id;}
            if($model)
            {
                self::addRecipients($model, $user_id, NotificationEvent::STATUS_READ);
                self::addRecipients($model, $recipient_id, NotificationEvent::STATUS_UNREAD);
            }
        }else {



            $name = ($user_id != $owner_id) ? $user_name : 'You';
            $text = sprintf("%s %s %s ", $name, $action_text, $job_name );
            $category = 'Email';
            $model = self::addNotification($user_id, $job_id, $category,$text, NotificationEvent::STATUS_READ);
            if($model){
                self::addRecipients($model, $user_id, NotificationEvent::STATUS_READ);
                if($user_id != $owner_id){
                    self::addRecipients($model, $owner_id, NotificationEvent::STATUS_UNREAD);
                }
            }



            if($event->status == 'Rolecall'){
                foreach ($modelJobItem->jobCategoryMappers as $jobCategoryMapper){
                    foreach($jobCategoryMapper->userJobCategoryMapper as $user){
                        self::addRecipients($model, $user->user_id, NotificationEvent::STATUS_READ);
                    }
                }
            }
        }

    }

    protected static function addNotification($user_id, $job_id, $category,$text, $notify = NotificationEvent::STATUS_UNREAD ){

        if(empty($user_id)) return false;
        $model 				= new UserNotification();
        $model->job_id		= $job_id;
        $model->seq 		= NotificationEvent::NOTIFICATION_SEQ;
        $model->sender_id	= $user_id;
        $model->ip 			= '';
        $model->text		= $text;
        $model->status		= $notify;
        $model->category	= $category;
        $model->time		= time();
        $model->identifier	= Yii::$app->security->generateRandomString();
        return ( $model->save(false) ) ? $model : false;
    }

    protected static function addRecipients($model, $user_id, $notify = NotificationEvent::STATUS_UNREAD ){

        if(empty($user_id)) return false;
        $modelRecipients = new UserNotificationRecipients();
        $modelRecipients->message_id 	= $model->message_id;
        $modelRecipients->seq 		 	= $model->seq;
        $modelRecipients->recipient_id 	= $user_id;
        $modelRecipients->status 		= $notify;
        $modelRecipients->time 			= time();
        return $modelRecipients->save(false);
    }

}