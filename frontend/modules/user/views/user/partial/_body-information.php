<?php
use yii\helpers\Html;

$gender = Yii::$app->user->identity->user->userProfile->gender;
?>

<div class="userbodyinformation bodyinformation">
    <h3>Talent Appearance</h3>
    <div class="row">
        <?php foreach ($sectionBodyInformation as $i => $userFieldValue){


           $is_valid = true;
           $is_valid = $is_valid && ( $gender == 'Male' && !in_array($userFieldValue->field->field, ['bust','hips','cup-size']));
           $is_valid = $is_valid || ($gender == 'Female' && !in_array($userFieldValue->field->field, ['neck','shoulders','chest']) );
            if( $is_valid ){
            ?>
                <div class="col-sm-3">
                    <div class="summery"><i class="fa cls-<?=$userFieldValue->field->field;?>" aria-hidden="true"></i>
                        <span class="sal">
                            <?= ( $userFieldValue->field->name == "Birthday" ) ? "Age" : $userFieldValue->field->name; ?>
                        </span>
                        <?php
                        switch($userFieldValue->field->type){
                            case 'MultiList':
                                if( $userFieldValue->field->is_serialize == 1 ){
                                    echo ( $data = @unserialize($userFieldValue->value)) ? implode(', ',$data) : $userFieldValue->value;
                                }else{
                                    echo trim($userFieldValue->value) ?? 'Not Given';
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
                                    switch ($userFieldValue->field->field){
                                        case "height":
                                            if( $userFieldValue->value > 0) {
                                                $inches = ceil($userFieldValue->value / 2.54);
                                                $feet = floor(($inches / 12));
                                                echo $feet . " ft. " . ($inches % 12) . ' in.';
                                            }
                                            break;
                                        case "weight":
                                            echo $userFieldValue->value . ' lbs.';
                                            break;
                                        case 'waist':
                                        case 'neck':
                                        case 'shoulders':
                                        case 'sleeve':
                                        case 'inseam':
                                        case 'bust':
                                        case 'hips':
                                        case 'chest':
                                            if( $userFieldValue->value > 0 ){
                                                echo ceil( $userFieldValue->value / 2.54 ) . " in.";
                                            }

                                        break;
                                        default:
                                          echo $userFieldValue->value;
                                    }
                                }

                                break;
                            case 'Radio':
                                echo $userFieldValue->value;
                                break;

                            case 'Text':
                                echo $userFieldValue->value;
                                break;

                            case 'DatePicker':
                                echo date_diff(date_create($userFieldValue->value), date_create('today'))->y . ' yrs';
                            default:
                        }

                        ?>
                    </div>
                </div>

        <?php }
            }
            ?>
    </div>
</div>