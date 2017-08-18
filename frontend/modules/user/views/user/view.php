<?php



use yii\helpers\Html;

use yii\widgets\DetailView;

use yii\helpers\Url;

use backend\modules\user\models\UserProfile;

use himiklab\thumbnail\EasyThumbnailImage;

use frontend\widgets\JobWidget;

use frontend\widgets\TalentWidget;

use frontend\widgets\JobUserWidget;



/* @var $this yii\web\View */

/* @var $model backend\modules\user\models\User */
$this->title = $model->userProfile->getName();
$userProfile    = Yii::$app->user->identity->userProfile;
$joining_date = isset($userProfile) ? Yii::$app->formatter->asDatetime($userProfile->joining_date, "php:d M Y") : '';
$location = null;
$role = Yii::$app->user->identity->getRolename();
?>

<header class="entry-header">
    <?php if(Yii::$app->user->identity->isDirector()){?>
        <?= Html::a('Start New Rolecall',['/job/job-item/create'],['class'=>'btn owner-button btn-start-new-rolecall', 'id' => 'Start-New-Rolecall']);?>
        <a href="" ></a>
    <?php } ?>
</header>
<?= (Yii::$app->user->identity->isDirector()) ? JobWidget::widget() : JobUserWidget::widget(); ?>
</div>

