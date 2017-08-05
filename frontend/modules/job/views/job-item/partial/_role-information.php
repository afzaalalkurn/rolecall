<?php
use yii\helpers\Html;
use backend\modules\job\models\JobItem;

?>

<div class="usersummary bodyinformation">
    <h3>Role Overview</h3>
    <div class="row">
        <?php
        $jobFieldArray = [];
        foreach ($sectionRoleInfo as $i => $jobFieldValue){

                    switch($jobFieldValue->field->type)
                    {
                        case 'MultiList':
                            if($jobFieldValue->field->is_serialize == 1){
                                $array = @unserialize($jobFieldValue->value);
                                $jobFieldArray[$jobFieldValue->field->field][$jobFieldValue->field->name] = $array ? implode(' , ',$array) : $jobFieldValue->value;

                            }else{
                                $jobFieldArray[$jobFieldValue->field->field][$jobFieldValue->field->name] = trim($jobFieldValue->value) ?? 'Not Given';
                            }
                            break;
                        case 'Text':
                            switch($jobFieldValue->field->field){
                                case "other-exp":
                                $jobFieldArray['real-world-experience']['Real World Experience'] = str_replace('Other', $jobFieldValue->value, $jobFieldArray['real-world-experience']['Real World Experience']);
                                    break;
                                case "other-lang":
                                $jobFieldArray['spoken-languages']['Spoken Languages'] = str_replace('Other', $jobFieldValue->value, $jobFieldArray['spoken-languages']['Spoken Languages']);
                                    break;
                                case "other-skill":
                                     $jobFieldArray['special-skills']['Special Skills'] =  str_replace('Other', $jobFieldValue->value, $jobFieldArray['special-skills']['Special Skills']);
                                    break;
                                case "role-name":
                                    $jobFieldArray[$jobFieldValue->field->field][$jobFieldValue->field->name] = $jobFieldValue->value;
                                    break;
                            }
                            break;
                        case 'List':
                            $jobFieldArray[$jobFieldValue->field->field][$jobFieldValue->field->name] = $jobFieldValue->value;
                        case 'TextArea':
                            $jobFieldArray[$jobFieldValue->field->field][$jobFieldValue->field->name] = $jobFieldValue->value;
                    }
                    ?>
        <?php }
        //pr($jobFieldArray,0);
        foreach($jobFieldArray as $jobFieldKey => $jobFieldVal){
            ?>
            <div class="col-sm-6">
                <div class="summery">
                    <i class="fa cls-<?=$jobFieldKey;?>" aria-hidden="true"></i>
                    <?php foreach($jobFieldVal as $key => $val){?>
                    <span class="sal"><?=$key?>:
                    </span>
                    <?php
                    echo $val;
                    } ?>
                </div>
            </div>
        <?php } ?>
        <?php ?>
    </div>
</div>