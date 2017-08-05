<?php
use yii\helpers\Html;
?>
<div class="usersummary bodyinformation">
    <h3>Talent Overview</h3>
    <div class="row">
        <?php 
        $userFieldArray = [];
        foreach ($sectionSummary as $i => $userFieldValue){ ?>
                    <?php
                    switch($userFieldValue->field->type){
                        case 'MultiList':
                            if($userFieldValue->field->is_serialize == 1){
                                $userFieldArray[$userFieldValue->field->field][$userFieldValue->field->name] = @unserialize($userFieldValue->value) ? implode(', ',@unserialize($userFieldValue->value)) : $userFieldValue->value;
                            }else{
                                $userFieldArray[$userFieldValue->field->field][$userFieldValue->field->name] = trim($userFieldValue->value) ?? Yii::t('job', 'Not Given');
                            }
                            break;
                        case 'List':
                            $userFieldArray[$userFieldValue->field->field][$userFieldValue->field->name] = $userFieldValue->value;
                            break;
                            case 'Text':
                            switch($userFieldValue->field->field){
                                case "other-exp":
                                $userFieldArray['real-world-experience']['Real World Experience'] = str_replace('Other', $userFieldValue->value, $userFieldArray['real-world-experience']['Real World Experience']);
                                    break;
                                case "other-lang":
                                $userFieldArray['spoken-languages']['Spoken Languages'] = str_replace('Other', $userFieldValue->value, $userFieldArray['spoken-languages']['Spoken Languages']);
                                    break;
                                case "other-skill":
                                $userFieldArray['special-skills']['Special Skills'] =  str_replace('Other', $userFieldValue->value, $userFieldArray['special-skills']['Special Skills']);
                                    break;
                                case "role-name":
                                $userFieldArray[$userFieldValue->field->field][$userFieldValue->field->name] = $userFieldValue->value;
                                    break;
                            }
                            break;
                        default:
                    }

                    ?>
                
        <?php }
        foreach ($userFieldArray as $userFieldKey => $userFieldval) {
             ?>
        <div class="col-sm-4">
        <div class="summery">
            <i class="fa cls-<?=$userFieldKey;?>" aria-hidden="true"></i>
            <?php foreach($userFieldval as $key => $val){?>
                    <span class="sal"><?=$key?>:
                    </span>
                    <?php
                    echo $val;
                    } ?>
                    </div>
            </div>
             <?php
        }
        ?>
        <?php ?>
    </div>
</div>