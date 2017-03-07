<?php
namespace frontend\modules\user\componants;

use yii\base\Component;
use frontend\event\NotificationEvent;

class UserNotification extends Component{
	 	
	public function handler(NotificationEvent $event){
	
		$model = new UserNotification();
	 
		switch($event->status){
	
			case NotificationEvent::JOB_APPLIED:
	
				$model->sender_id	= $event->user_id;
				$model->job_id  	= $event->job_id;
				$model->seq  		= NotificationEvent::NOTIFICATION_SEQ;
				$model->category 	= NotificationEvent::TYPE_NOTIFY;
				$model->text		= sprintf("%s %s %s ", $event->user_id, NotificationEvent::JOB_APPLIED, $event->job_id);
				$model->status		= NotificationEvent::STATUS_READ;
	
				if($model->save()){
					$model = new UserNotificationRecipients();
					$model->message_id
				}
	
	
	
	
				echo "<pre>";
				print_R($event);
				exit;
				break;
			case NotificationEvent::JOB_FAVORITE:
	
				break;
			case NotificationEvent::JOB_SAVED:
	
				break;
		}
	
	}
	
}