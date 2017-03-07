<?php
use yii\helpers\Html;
use backend\modules\job\models\JobItem;

?>

<div class="usersummary bodyinformation">
    <h3>Role Overview</h3>
    <div class="row">
        <?php foreach ($sectionRoleInfo as $i => $jobFieldValue){
            ?>
            <div class="col-sm-6">
                <div class="summery"><i class="fa cls-<?=$jobFieldValue->field->field;?>" aria-hidden="true"></i>
                    <span class="sal"><?=$jobFieldValue->field->name;?> :</span>

                    <?php if ($jobFieldValue->field->type == 'MultiList') {
                        ?>
                        <?= ( $data = @unserialize($jobFieldValue->value)) ? implode(', ',$data) : $jobFieldValue->value; ?>
                        <?php //implode(', ', unserialize($jobFieldValue->value)); ?>
                    <?php } else { ?>
                        <?= trim($jobFieldValue->value) ?? Yii::t('job', 'Not Given'); ?>
                    <?php } ?>

                </div>
            </div>
        <?php } ?>
        <?php ?>
    </div>
</div>