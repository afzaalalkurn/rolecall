<?php
use yii\helpers\Html;
use backend\modules\job\models\JobItem;

?>

<div class="usersummary bodyinformation">
    <h3>Vehicle Appearance</h3>
    <div class="row">
        <?php foreach ($sectionVehicleInfo as $i => $jobFieldValue){
            ?>
            <div class="col-sm-6">
                <div class="summery"><i class="fa cls-<?=$jobFieldValue->field->field;?>" aria-hidden="true"></i>
                    <span class="sal"><?=$jobFieldValue->field->name;?> :</span>
                    <?php
                    $vehicleField = $jobFieldValue->field->field ;
                    $vehicleVal = $jobFieldValue->value;
                    if ($jobFieldValue->field->type == 'MultiList') {
                        ?>
                        <?= ( $data = @unserialize($jobFieldValue->value)) ? implode(', ',$data) : $jobFieldValue->value; ?>
                        <?php //implode(', ', unserialize($jobFieldValue->value)); ?>
                    <?php
                        if(($vehicleField == "car") && ($vehicleVal == "No"))
                        {
                            break;
                        }
                    } else { ?>
                        <?= trim($jobFieldValue->value) ?? Yii::t('job', 'Not Given'); ?>
                    <?php
                        if(($vehicleField == "car") && ($vehicleVal == "No"))
                        {
                            break;
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php ?>
    </div>
</div>