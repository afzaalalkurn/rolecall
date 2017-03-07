<?php
use yii\helpers\Html;
?>

<div class="jb-details">
    <div class="row">
        <div class="btn-sequence">
            <div class="btndiv">
                <?= ( isset(Yii::$app->user->id) && Yii::$app->user->identity->isUser()) ? $this->render('_mailbtn', [ 'model' => $model, 'job_id' => $model->job_id,]) : null; ?>

                <?php /* ( isset(Yii::$app->user->id) && Yii::$app->user->identity->isDirectorUserId($model->user_id)) ? $this->render('_sponsorbtn', [ 'job_id' => $model->job_id,]) : null; */?>


                <?php if (isset($tpls) && count($tpls) > 0) { ?>
                    <?php foreach ($tpls as $key => $tpl) { ?>
                        <?php if (isset($tpl) && count($tpl) > 0) { ?>
                            <?= Html::button($tpl['title'], ['value' => $tpl['path'], 'class' => $tpl['class'], 'id' => $tpl['id'], 'status' => $tpl['item']]); ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

    </div>
</div>
