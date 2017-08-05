<?php
namespace frontend\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class UserSettingsWidget extends Widget{
    public $user_id;
    public function init(){
        parent::init();
        if ($this->user_id === null) {
            $this->user_id = isset(Yii::$app->user->id) ?
                Yii::$app->user->id : null;
        }
    }

    public function run(){

        $tpls = $this->_commonButtons();
    return $this->render('settings-sidebar',
        ['user_id' => $this->user_id, 'tpls'=>$tpls]);
    }

    protected function _commonButtons(){
        $links  =   [
            'Notifications Settings' => Url::to(['/user/user/settings']),
            'Change Password' => Url::to(['/change-password']),
            'Delete Account' => Url::to(['/user/user/delete-user','id' => Yii::$app->user->id])
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
}
?>