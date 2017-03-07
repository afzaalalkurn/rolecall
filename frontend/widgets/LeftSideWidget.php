<?php
namespace frontend\widgets;
use backend\modules\job\models\search\JobItem;
use backend\modules\user\models\search\Talent;
use Yii;use yii\base\Widget;
use yii\helpers\Url;
use backend\modules\job\models\search\JobUserMapper;
class LeftSideWidget extends Widget
{
    public $user_id;
    public function init(){
        parent::init();
        if ($this->user_id === null) {
            $this->user_id = isset(Yii::$app->user->id) ?
                Yii::$app->user->id : null;
        }
    }
    public function run(){
    if(isset(Yii::$app->user->id)){
        $tpls = (Yii::$app->user->identity->isDirector()) ?
            $this->_ownerButtons() : $this->_userButtons();
        /*$tpls  =  array_merge( $tpls, $this->_commonButtons());*/
    }else{
        $tpls[]  =  $this->_guestButtons();
    }
    return $this->render('left-sidebar',
        ['user_id' => $this->user_id, 'tpls'=>$tpls]);
    }
    protected function _commonButtons(){
        $links  =   [
            'Change Password' => Url::to(['/change-password']),
            'Profile'         => Url::to(['/user/user/view']),
            'Update Profile'      => Url::to(['/update']),
            'User Message'        => Url::to(['/user/user-msg'])
        ];
        foreach ($links as $name => $path){
            $tpls[] =
                ['item'      => $name,
                    'title'     => $name,
                    'path'      => $path,
                    'id'        => str_replace(' ' ,'-', $name),
                    'class'     => 'btn owner-button btn-'.strtolower(str_replace(' ' ,'-', $name)),];
        }
        return $tpls;
    }
    protected function _ownerButtons(){
        $job_id = Yii::$app->getRequest()->getQueryParam('id');
        $JobUserMapper = new JobUserMapper();
        $count = null;
        $status = null;
        $searchModel = new Talent();
        $model = new JobItem();
        $tpls = [];
        $links = [
            /*'Banner'         => Url::to(['/user/user-ads/']),
             Selected Talents' => Url::to(['/job-talents', 'status'=>'Pending']),
               'Approved Talents' => Url::to(['/job-talents', 'status'=>'Approved']),
                       'My Rolecalls'     => Url::to(['/my-jobs']),*/
            'Talent Matches' => ['url' => Url::to(['/job/job-item/talents', 'id' => $job_id]),
                'status' => 'Matches'],
            'Talent Selects' => ['url' => Url::to(['/job-talents', 'status' => 'Approved', 'id' => $job_id]),
                'status' => 'Approved'],
            'Talent Passes' => ['url' => Url::to(['/job-talents', 'status' => 'Declined', 'id' => $job_id]),
                'status' => 'Declined'],
            'Talent Booked' => ['url' => Url::to(['/job-talents', 'status' => 'Booked', 'id' => $job_id]),
                'status' => 'Booked'],        ];
        foreach ($links as $name => $path) {
            foreach ($path as $key => $value) {
                if ($value == 'Matches') {
                    $searchModel->job_id = $job_id;
                    $searchModel->latitude = $model->latitude;
                    $searchModel->longitude = $model->longitude;
                    $searchModel->radius = $model->radius;
                    $count = $searchModel->search(Yii::$app->request->queryParams)->totalCount;
                } else {
                    $count = $JobUserMapper->getTalentCount($value, $job_id);
                }
                $status = $value;
            }
            $tpls[] = [ 'item'      => $name,
                'title'     => $name,
                'path'      => $path['url'],
                'id'        => str_replace(' ' ,'-', $name),
                'count'     => $count,
                'status'    => $status,
                'class'     => 'btn owner-button btn-'.strtolower(str_replace(' ' ,'-', $name)),];
        }
        return $tpls;
    }
    protected function _userButtons(){
        $tpls = [];
        $user_id = Yii::$app->user->id;
        $JobUserMapper = new JobUserMapper();
        $count = null;
        foreach ([/*'Applied' => 'Applied Rolecall',*/
        /*'Favorite' => 'Favorite Rolecall',*/
                     'Pending' => 'Rolecall Matches',
                     'Approved' => 'Rolecall Selects',
                     'Passed' => 'Rolecall Passes',
                     'Booked' => 'Rolecall Booked',
                 ]
                 as $status => $name ) {
            $count = $JobUserMapper->getRolecallCount($status,$user_id);
            $tpls[] =   [
                'item'  => $status,
                'title' => $name,
                'id' => 'status-' . $status,
                'path' => Url::to(['/job/job-user-mapper',
                    'user_id' => $user_id,
                    'status' => $status]),
                'count'     => $count,
                'status' => $status,
                'class' => 'btn user-mapper btn-'.strtolower($status),];
        }
        return $tpls;
    }
    protected function _guestButtons(){
        $tpls = [];        return $tpls;
    }
}