<?php
namespace frontend\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use backend\modules\user\models\User;

class RightTopWidget extends Widget
{
    public $user_id;

    public function init()
    {
        parent::init();
        if ($this->user_id === null) {
            $this->user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : null;
        }
    }

    public function run()
    {

        if (isset(Yii::$app->user->id)) {
            $tpls  =  ( Yii::$app->user->identity->isDirector() ) ? $this->_ownerButtons() : $this->_userButtons();
            $tpls  =  array_merge( $tpls, $this->_commonButtons());
        } else {
            $tpls[] = $this->_guestButtons();
        }
        return $this->render('right-top-sidebar', ['user_id' => $this->user_id, 'tpls' => $tpls]);
    }


    protected function _commonButtons()
    {

        $links = [
            'Profile' => Url::to(['/user/user/view']),
            'Change Password' => Url::to(['/change-password']),
            'User Message'        => Url::to(['/user/user-msg'])
        ];

        foreach ($links as $name => $path) {
            $tpls[] = [
                'item' => $name,
                'title' => $name,
                'path' => $path,
                'id' => str_replace(' ', '-', $name),
                'class' => 'btn owner-button btn-' . strtolower(str_replace(' ', '-', $name)),
            ];
        }
        return $tpls;
    }


    protected function _ownerButtons()
    {

        $job_id = Yii::$app->getRequest()->getQueryParam('id');
        $id = Yii::$app->user->id;
        $model =  User::findOne($id);
        $userProfile = $model->userProfile;

        $tpls = [];
        $links = [
            'Archived RoleCalls' => Url::to(['/job/job-item/archive']),
        ];

        ?>
        <?php
        //$links['Settings'] = Url::to(['/user/user/settings']);

        foreach ($links as $name => $path) {
            $tpls[] = [
                'item' => $name,
                'title' => $name,
                'path' => $path,
                'id' => str_replace(' ', '-', $name),
                'class' => 'btn owner-button btn-' . strtolower(str_replace(' ', '-', $name)),
            ];
        }
        return $tpls;
    }


    protected function _userButtons()
    {
        $tpls = [];
        $id = Yii::$app->user->id;
        $model =  User::findOne($id);
        $userProfile = $model->userProfile;

        $links = [];

        ?>
        
        <?php
        //$links['Settings'] = Url::to(['/user/user/settings']);

        foreach ($links as $name => $path) {
            $tpls[] = [
                'item' => $name,
                'title' => $name,
                'path' => $path,
                'id' => str_replace(' ', '-', $name),
                'class' => 'btn user-mapper btn-' . strtolower(str_replace(' ', '-', $name)),
            ];
        }
        return $tpls;
    }


    protected function _guestButtons()
    {
        $tpls = [];
        return $tpls;
    }
}
