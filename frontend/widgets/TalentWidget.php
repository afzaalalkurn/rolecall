<?php
namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class TalentWidget extends Widget
{

    public $user_id;
    public $job_id;

    public function init(){
        parent::init();
        if ($this->user_id === null) {
            $this->user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : null;
        }
    }

    public function run(){
            return $this->render('talents', ['user_id' => $this->user_id, 'job_id' => $this->job_id]);
    }

}

