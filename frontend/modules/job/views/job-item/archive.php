<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use backend\modules\user\models\UserProfile;
use himiklab\thumbnail\EasyThumbnailImage;
use frontend\widgets\JobWidget;
use frontend\widgets\ArchiveJobWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$userProfile    = Yii::$app->user->identity->userProfile;
$joining_date = isset($userProfile) ? Yii::$app->formatter->asDatetime($userProfile->joining_date, "php:d M Y") : '';
$location = null;
$role = Yii::$app->user->identity->getRolename();
?>
<header class="entry-header">
    <?php if($role == "Director"){?>
        <a href="/job/job-item/create" class="btn owner-button btn-start-new-rolecall" id="Start-New-Rolecall">Start New Rolecall</a>
        <a href="/job/job-item/archive" class="btn owner-button btn-archive-rolecall" id="Archive-Rolecall">Archive Rolecall</a>
    <?php }?>
</header>

<?php if(Yii::$app->user->identity->isDirector()){?>
    <?=ArchiveJobWidget::widget();?>
<?php }
?>

</div>
