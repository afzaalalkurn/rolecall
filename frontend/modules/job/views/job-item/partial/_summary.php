<?php
use yii\helpers\Html;
use backend\modules\job\models\JobItem;

/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 13/7/16
 * Time: 3:23 PM
 */
/*pr($model->getJobFieldValues()
    ->where(['job_field.section'=>'Summary',
        'job_field.field_id'=>'field_id'])
    ->all());*/
//foreach ($model->jobFieldValues as $i => $jobFieldValue){
//
//    //$model->setField($jobFieldValue->field->field,$jobFieldValue->value);
//}
//$modelJobFieldValues

?>
        <?php foreach ($sectionSummary as $i => $jobFieldValue){
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
