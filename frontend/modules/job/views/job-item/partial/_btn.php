<?php
use yii\helpers\Html;
use backend\modules\job\models\JobUserMapper;

$approved = JobUserMapper::findOne(['job_id' => $model->job_id, 'user_id' => Yii::$app->user->id, 'status' => 'Approved']);
$role = Yii::$app->user->identity->getRoleName();
?>
<div class="jb-details">
    <div class="row">
        <div class="btn-sequence">
            <div class="btndiv">
                <?= ( isset(Yii::$app->user->id) && Yii::$app->user->identity->isDirector() && $approved )
                    ? $this->render('_mailbtn',
                        [ 'model' => $model, 'job_id' => $model->job_id,]) : null;
                ?>
                <?php
                if (isset($tpls) && count($tpls) > 0) { ?>
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
