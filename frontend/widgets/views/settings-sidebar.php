<?php
use yii\helpers\Html;
use yii\helpers\Url;

if( isset($tpls) && count($tpls) > 0){
    foreach ($tpls as $key => $tpl) {
        if( isset($tpl) && count($tpl) > 0){
            $active = '';
            ?>
            <li <?=$active;?>>
                <?= Html::a($tpl['title'], $tpl['path'],
                    ['class' => $tpl['class'], 'id'=>$tpl['id'],
                        'status'=>$tpl['item']
                    ]);
                ?>
            </li>
        <?php
        }
    }
} ?>
