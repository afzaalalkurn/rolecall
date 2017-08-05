<?php
use yii\helpers\Html;
?>
<div class="userother">
    <h3>Rolecall Others</h3>
    <div class="row">
        <div class="col-sm-6">
            <div class="summery">
                <i class="fa cls-Location" aria-hidden="true"></i>
                <span class="sal">Location</span>
                <?=$userAddress->location;?>
            </div>
        </div>
        <?php foreach ($sectionOther as $i => $userFieldValue){ ?>
        <div class="col-sm-6">
            <div class="summery">
            <i class="fa cls-<?=$userFieldValue->field->field;?>" aria-hidden="true"></i><span class="sal">
                    <?=$userFieldValue->field->name;?>
                </span>
                <?php
                switch($userFieldValue->field->type){
                    case 'MultiList':
                        if($userFieldValue->field->is_serialize == 1){
                            echo ( $data = @unserialize($userFieldValue->value)) ? implode(', ',$data) : $userFieldValue->value;
                        }else{
                            echo trim($userFieldValue->value) ?? Yii::t('job', 'Not Given');
                        }
                        break;
                    case 'List':
                        if($userFieldValue->value == 'Other'){
                            foreach ($userFieldValue->field->userFields as $field){
                                foreach($field->userFieldValues as $value){
                                    echo $value->value;
                                }
                            }
                        }else{
                            echo $userFieldValue->value;
                        }
                        break;
                    case 'Text':
                        echo $userFieldValue->value;
                        break;
                    default:
                }

                ?>
            </div>
        </div>
            <?php } ?>
    </div>
</div>