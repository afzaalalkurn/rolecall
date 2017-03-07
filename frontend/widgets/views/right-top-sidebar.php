<?php
use yii\helpers\Html;
?>

<?php

if( isset($tpls) && count($tpls) > 0){?>
    <?php foreach ($tpls as $key => $tpl) {?>
        <?php if( isset($tpl) && count($tpl) > 0){?>
            <li><?= Html::a($tpl['title'],$tpl['path'],
                    ['class' => $tpl['class'], 'id'=>$tpl['id'], 'status'=>$tpl['item']]);?>
            </li>
        <?php } ?>
    <?php } ?>
    <?/*= ( isset( Yii::$app->user->id ) ) ? $this->render('partial/_upgradebtn', [ 'id' => Yii::$app->user->id,]) : null;*/?>
<?php } ?>