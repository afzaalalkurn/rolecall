<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\jui\Tabs;
use yii\helpers\Url;
use backend\modules\user\models\UserProfile; 

$this->title = 'My Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-12">
<div class="site-dashboard pe-animation-maybe" data-animation="fadeInLeft">
    <h1 class="dashtitle"><?= Html::encode($this->title) ?></h1> 
     <?=Yii::$app->runAction('/user/user')?>
</div>
</div>
</div>
