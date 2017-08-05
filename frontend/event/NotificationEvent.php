<?php



namespace frontend\event;



use yii\base\Event;



class NotificationEvent extends Event {





    const NOTIFICATION_JOB 		    = 'Rolecall';

    const NOTIFICATION_JOB_UPDATE    = 'updated Rolecall';

    const NOTIFICATION_APPLIED 	    = 'Applied';

    const NOTIFICATION_FAVORITE      = 'Favorite';

    const NOTIFICATION_SAVED         = 'Saved';

    const NOTIFICATION_SELECTED      = 'Selected';

    const NOTIFICATION_APPROVED      = 'Approved';

    const NOTIFICATION_PASSED        = 'Passed';

    const NOTIFICATION_BOOKED        = 'Booked';

    const NOTIFICATION_DECLINED      = 'Declined';

    const NOTIFICATION_SEND	        = 'Send';



    const TYPE_NOTIFY                = 'Notification';

    const TYPE_EMAIL 		        = 'Email';

    const TYPE_ALERT			        = 'Alert';



    const STATUS_READ		        = 'Read';

    const STATUS_UNREAD		        = 'UnRead';

    const STATUS_DELETED		        = 'Deleted';

    const STATUS_SPAN		        = 'Span';

    const STATUS_ARCHIVED	        = 'Archived';

    const NOTIFICATION_SEQ	        = 1;



    public $id;

    public $status;

    public $user_id;

    public $msg_id;


}

