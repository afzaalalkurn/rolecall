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
        <?php
        $jobFieldArray = [];
        foreach ($sectionBodyInfo as $i => $jobFieldValue){

            $is_valid = true;
            $is_valid = $is_valid && ( $gender == 'Male' && !in_array($jobFieldValue->field->field, ['bust-from', 'bust-to','hips-from', 'hips-to','cup-size']));
            $is_valid = $is_valid || ( $gender == 'Female' && !in_array($jobFieldValue->field->field, ['neck-from', 'neck-to','shoulders-from', 'shoulders-to','chest-from', 'chest-to']) );

            if( $is_valid ){ ?>
                    <?php
                    switch($jobFieldValue->field->type)
                    {
                        case 'MultiList':
                            if($jobFieldValue->field->is_serialize == 1){
                                $jobFieldArray[$jobFieldValue->field->name][]  = @unserialize($jobFieldValue->value) ? implode(', ',@unserialize($jobFieldValue->value)) : $jobFieldValue->value;
                            }else{
                                $jobFieldArray[$jobFieldValue->field->name][] = trim($jobFieldValue->value) ?? 'Not Given';
                            }
                            break;
                        case 'List':
                            $jobFieldArray[$jobFieldValue->field->name][] = $jobFieldValue->value;
                            break;
                        case 'Radio':
                            $jobFieldArray[$jobFieldValue->field->name][] = $jobFieldValue->value;
                            break;
                        case 'Text':
                            $jobFieldArray[$jobFieldValue->field->name][] = $jobFieldValue->value .' yrs';
                            break;
                        case 'DropdownRange':
                        case 'TextRange':
                            switch ($jobFieldValue->field->field){
                                case "age-from":
                                case "age-to":
                                $jobFieldArray[$jobFieldValue->field->name][] = $jobFieldValue->value .' yrs';
                                    break;
                                case "height-from":
                                case "height-to":
                                    if($jobFieldValue->value > 0) {
                                        $inches = ceil($jobFieldValue->value / 2.54);
                                        $feet = floor(($inches / 12));
                                        $feetVal = $feet . " ft. " . ($inches % 12) . ' in.';
                                        $jobFieldArray[$jobFieldValue->field->name][] = $feet . " ft. " . ($inches % 12) . ' in.';;
                                    }
                                    break;
                                case "weight-from":
                                case "weight-to":
                                $jobFieldArray[$jobFieldValue->field->name][] = $jobFieldValue->value . ' lbs.';
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
                                        $jobFieldArray[$jobFieldValue->field->name][] = ceil( $jobFieldValue->value / 2.54 ) . " in.";
                                    }

                                    break;
                                default:
                                    $jobFieldArray[$jobFieldValue->field->name][] = $jobFieldValue->value;
                            }
                            break;
                        case 'DateRange':
                            $jobFieldArray[$jobFieldValue->field->name][] = Yii::$app->formatter->asDatetime($jobFieldValue->value, "php:Y-m-d");
                            break;
                        case 'DatePicker';
                            $dob =  Yii::$app->formatter->asDatetime($jobFieldValue->value, "php:Y-m-d");
                            $datetime1 = new DateTime($dob);
                            $datetime2 = new DateTime();
                            $diff = $datetime1->diff($datetime2);
                            $jobFieldArray[$jobFieldValue->field->name][] = ($diff->y > 0) ? $diff->y.' yrs' : $diff->m. ' months';
                    }
                    ?>
        <?php } ?>
        <?php }
        $k =1;
        foreach($jobFieldArray as $jobFieldKey => $jobFieldVal){
            ?>
        <div class="col-sm-3">
            <div class="summery">
                    <span class="sal"><?=$jobFieldKey?> : </span>
                    <?php foreach ($jobFieldVal as $key=>$val){
                        if($key == 1){
                            echo " - " . $val;
                        }
                        else{
                            echo $val;
                        }

                    }?>
            </div>
        </div>
            <?php
            if($k % 4 == 0){
                echo '<div style="clear:both;"></div>';
            }
            $k++;
        }
        ?>
    </div>
</div>