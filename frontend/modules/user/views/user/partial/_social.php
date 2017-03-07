<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\user\models\UserSocial;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use backend\modules\core\models\CoreSocialNetwork;
$networkList = ArrayHelper::map(CoreSocialNetwork::find()->all(),'id', 'network');
?>
<div class="social">
    <?=Yii::t('app','Follow us at');?>:
<?php foreach ($model->userSocials as $networkId => $network) { ?>
        <a href="<?=$network->link?>" target="_blank"><i class="fa fa-<?=$networkList[$network->network_id]?>" aria-hidden="true"></i></a>
<? } ?>
</div>
