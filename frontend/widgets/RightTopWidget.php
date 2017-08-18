<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use backend\modules\user\models\User;

class RightTopWidget extends Widget
{
    public $user_id;
    public $type;

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

            if (!empty($this->type)) {
                switch ($this->type) {
                    case 'setting':
                        $tpls = (Yii::$app->user->identity->isDirector()) ? $this->_ownerSettingButtons() : $this->_userSettingButtons();
                        break;
                }
            } else {

                $tpls = (Yii::$app->user->identity->isDirector()) ? $this->_ownerButtons() : $this->_userButtons();
                $tpls = array_merge($tpls, $this->_commonButtons());
            }

        } else {
            $tpls[] = $this->_guestButtons();
        }
        return $this->render('right-top-sidebar', ['user_id' => $this->user_id, 'tpls' => $tpls]);
    }

    protected function _ownerSettingButtons()
    {
        $links = [];

        $plan_id = Yii::$app->user->identity->userProfile->plan_id;
        if ($plan_id == 1) {
            $links['Upgrade to Plus'] = Url::to(['/user/user/upgrade', 'id' => Yii::$app->user->id,]);
        }

        if ($plan_id > 1) {
            $links['Downgrade Account'] = Url::to(['/user/user/upgrade', 'id' => Yii::$app->user->id,]);
        }

        $links['Change Password'] = Url::to(['/change-password']);
        $links['Delete Account'] = Url::to(['/request-delete-account']);

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


    protected function _userSettingButtons()
    {

        $plan_id = Yii::$app->user->identity->userProfile->plan_id;
        if ($plan_id == 1) {
            $links['Upgrade to Plus'] = Url::to(['/user/user/upgrade', 'id' => Yii::$app->user->id,]);
        }

        if ($plan_id > 1) {
            $links['Downgrade Account'] = Url::to(['/user/user/upgrade', 'id' => Yii::$app->user->id,]);
        }

        $links['Change Password'] = Url::to(['/change-password']);

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
        $model = User::findOne($id);
        $userProfile = $model->userProfile;
        $tpls = [];
        $links['Archived RoleCalls'] = Url::to(['/job/job-item/archive']);

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
        $model = User::findOne($id);
        $userProfile = $model->userProfile;
        $links = [];

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

    protected function _commonButtons()
    {

        $links = [
            'Profile' => Url::to(['/user/user/view']),
            'User Message' => Url::to(['/user/user-msg'])
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

    protected function _guestButtons()
    {
        $tpls = [];
        return $tpls;
    }
}
