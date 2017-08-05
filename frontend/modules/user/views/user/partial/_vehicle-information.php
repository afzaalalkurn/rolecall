<?php
use yii\helpers\Html;

?>

<div class="userbodyinformation bodyinformation">
    <h3>Vehicle Appearance</h3>
    <div class="row">
        <?php foreach ($sectionVehicleInformation as $i => $userFieldValue){ ?>
            <div class="col-sm-3">
                <div class="summery">
                <i class="fa cls-<?=$userFieldValue->field->field;?>" aria-hidden="true"></i>
                <?php
                $vehicleField = $userFieldValue->field->field ;
                $vehicleVal = $userFieldValue->value;
                ?>
                <span class="sal">
                    <?= $userFieldValue->field->name; ?>
                </span>
                <?php
                if ($userFieldValue->field->type == 'MultiList') {
                    ?>
                    <?= ( $data = @unserialize($userFieldValue->value)) ? implode(', ',$data) : $userFieldValue->value; ?>
                    <?php //implode(', ', unserialize($userFieldValue->value)); ?>
                    <?php
                    if(($vehicleField == "do-you-own-vehicle") && ($vehicleVal == "No"))
                    {
                        break;
                    }
                } else { ?>
                    <?= trim($userFieldValue->value); ?>
                    <?php
                    if(($vehicleField == "do-you-own-vehicle") && ($vehicleVal == "No"))
                    {
                        break;
                    }
                }
                ?>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>

