<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserNotification */

$this->title = $model->message_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<header class="entry-header">
    <h1 class="dashtitle">User Notifications</h1>
</header>
<div class="user-school-msg-view">
    <div class="productbgcolor">
        <?= Html::a(Yii::t('app', 'Back'),   ['index'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php
    $name = $model->sender->userProfile->name;
    ?>
    <div class="productbgcolor mailbox">
        <div class="jobitembox msg-<?=$model->status;?>" message_id="<?=$model->message_id;?>" seq="<?=$model->seq;?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <!--<h3><i class="fa fa-user" aria-hidden="true"></i> <?= Html::encode($name); ?></h3>-->
                            <span class="schoolname"><strong>Rolecall :</strong> <?= Html::encode($model->job->name); ?></span>

                            <div class="loccaltime">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="date">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo date("j M Y", strtotime($model->created_on)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p><?= Yii::$app->formatter->asHtml($model->text); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?/*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'message_id',
            'identifier',
            'job_id',
            'seq',
            'sender_id',
            'text:ntext',
            'ip',
            'category',
            'status',
            'time:datetime',
            'created_on',
        ],
    ]) */?>

</div>
</div>
