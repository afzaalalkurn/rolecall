<?php
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 13/7/16
 * Time: 3:38 PM
 */
?>
<div class="userbodyinformation bodyinformation">
    <h3>Talent Appearance</h3>
    <div class="row">
        <?php foreach ($sectionBodyInfo as $i => $jobFieldValue){

            $is_valid = true;
            $is_valid = $is_valid && ( $gender == 'Male' && !in_array($jobFieldValue->field->field, ['bust-from', 'bust-to','hips-from', 'hips-to','cup-size']));
            $is_valid = $is_valid || ( $gender == 'Female' && !in_array($jobFieldValue->field->field, ['neck-from', 'neck-to','shoulders-from', 'shoulders-to','chest-from', 'chest-to']) );

            if( $is_valid ){ ?>
            <div class="col-sm-3">
                <div class="summery">
                    <span class="sal"><?=$jobFieldValue->field->name;?> :</span>

                    <?php

                    switch($jobFieldValue->field->type)
                    {
                        case 'MultiList':
                            if($jobFieldValue->field->is_serialize == 1){
                                echo ( $data = @unserialize($jobFieldValue->value)) ? implode(', ',$data) : $jobFieldValue->value;
                            }else{
                                echo trim($jobFieldValue->value) ?? 'Not Given';
                            }
                            break;
                        case 'List':
                           echo $jobFieldValue->value;
                            break;
                        case 'Radio':
                            echo $jobFieldValue->value;
                            break;
                        case 'Text':
                            echo $jobFieldValue->value .'yrs';
                            break;

                        case 'DropdownRange':
                        case 'TextRange':
                            switch ($jobFieldValue->field->field){
                                case "age-from":
                                case "age-to":
                                echo $jobFieldValue->value . ' yrs';
                                    break;
                                case "height-from":
                                case "height-to":
                                    if($jobFieldValue->value > 0) {
                                        $inches = ceil($jobFieldValue->value / 2.54);
                                        $feet = floor(($inches / 12));
                                        echo $feet . " ft. " . ($inches % 12) . ' in.';
                                    }
                                    break;
                                case "weight-from":
                                case "weight-to":
                                    echo $jobFieldValue->value . ' lbs.';
                                    break;
                                case 'waist-from':
                                case 'waist-to':
                                case 'neck-from':
                                case 'neck-to':
                                case 'shoulders-from':
                                case 'shoulders-to':
                                case 'sleeve-from':
                                case 'sleeve-to':
                                case 'inseam-from':
                                case 'inseam-to':
                                case 'bust-from':
                                case 'bust-to':
                                case 'hips-from':
                                case 'hips-to':
                                case 'chest-from':
                                case 'chest-to':
                                    if( $jobFieldValue->value > 0 ){
                                        echo ceil( $jobFieldValue->value / 2.54 ) . " in.";
                                    }
                                    break;
                                default:
                                    echo $jobFieldValue->value;
                            }
                            break;
                        case 'DateRange':
                            echo Yii::$app->formatter->asDatetime($jobFieldValue->value, "php:Y-m-d");
                            break;
                        case 'DatePicker';
                            $dob =  Yii::$app->formatter->asDatetime($jobFieldValue->value, "php:Y-m-d");
                            $datetime1 = new DateTime($dob);
                            $datetime2 = new DateTime();
                            $diff = $datetime1->diff($datetime2);
                            echo $age = ($diff->y > 0) ? $diff->y.' yrs' : $diff->m. ' months';
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>