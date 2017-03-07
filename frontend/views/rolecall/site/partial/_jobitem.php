<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
?>
<li>
    <div class="thumbnail">
        <?= Html::a(Html::img('@web/images/school01.jpg', ['alt' => ""]), ['#']);?>
    </div>
    <div class="school-details">
        <div class="job-name">
            <div class="school-logo">
                <?= Html::a(Html::img('@web/images/director-logo.jpg', ['alt' => ""]), ['#']);?>
            </div>
            <div class="job-title">
                <?= Html::a( $model->name,['/job/job-item/view', 'id'=>$model->job_id]) ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="job-desc">
            <?=StringHelper::truncateWords($model->description,15); ?>
        </div>
    </div>
</li>