<?php
namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
class RightTopWidget extends Widget
{

    public $user_id;

    public function init(){
        parent::init();
        if ($this->user_id === null) {
            $this->user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : null;
        }
    }

    public function run(){
        if( isset(Yii::$app->user->id) ){
            //$tpls  =  ( Yii::$app->user->identity->isDirector() ) ? $this->_ownerButtons() : $this->_userButtons();

            $tpls  =  $this->_commonButtons();

        }else{
            $tpls[]  =  $this->_guestButtons();
        }


        return $this->render('right-top-sidebar', ['user_id' => $this->user_id, 'tpls'=>$tpls]);
    }

    protected function _commonButtons(){
        $links  =   [
            'Change Password'     => Url::to(['/change-password']),
            'Profile'             => Url::to(['/user/user/view']),
            'Update Profile'              => Url::to(['/update']),
            'User Message'        => Url::to(['/user/user-msg'])
        ];

        foreach ($links as $name => $path){

            $tpls[] = [
                'item'      => $name,
                'title'     => $name,
                'path'      => $path,
                'id'        => str_replace(' ' ,'-', $name),
                'class'     => 'btn owner-button btn-'.strtolower(str_replace(' ' ,'-', $name)),
            ];
        }

        return $tpls;

    }

    protected function _ownerButtons(){
        $job_id = Yii::$app->getRequest()->getQueryParam('id');
        $tpls   = [];
        $links  =   [
            /*'Banner'              => Url::to(['/user/user-ads/']),
             'Selected Talents'             => Url::to(['/job-talents', 'status'=>'Pending']),
             'Approved Talents'             => Url::to(['/job-talents', 'status'=>'Approved']),
             'My Rolecalls'             => Url::to(['/my-jobs']),*/
            'Matches' => Url::to(['/job/job-item/talents','id' => $job_id]),
            'Selected' => Url::to(['/job-talents', 'status'=>'Selected','id' => $job_id]),
            'Passes' => Url::to(['/job-talents', 'status'=>'Declined','id' => $job_id]),
            'Booked' => Url::to(['/job-talents', 'status'=>'Booked','id' => $job_id]),
        ];

        foreach ($links as $name => $path) {
            $tpls[] = [
                'item'      => $name,
                'title'     => $name,
                'path'      => $path,
                'id'        => str_replace(' ' ,'-', $name),
                'class'     => 'btn owner-button btn-'.strtolower(str_replace(' ' ,'-', $name)),
            ];
        }
        return $tpls;
    }

    protected function _userButtons(){

        $tpls = [];

        foreach ([/*'Applied' => 'Applied Rolecall',*/
                     /*'Favorite' => 'Favorite Rolecall',*/
                     'Pending' => 'Matches',
                     'Approved' => 'Selected',
                     'Declined' => 'Passed',
                     'Booked' => 'Booked',
                 ]
                 as $status => $name ) {
            $tpls[] =   [
                'item'  => $status,
                'title' => $name,
                'id' => 'status-' . $status,
                'path' => Url::to(['/job/job-user-mapper/index', 'user_id' => Yii::$app->user->id, 'status' => $status]),
                'class' => 'btn user-mapper btn-'.strtolower($status),
            ];
        }

        return $tpls;

    }

    protected function _guestButtons(){
        $tpls = [];

        return $tpls;
    }

}

