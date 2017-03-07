<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\user\models\UserSocial;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use backend\modules\core\models\CoreSocialNetwork;
$networkList = ArrayHelper::map(CoreSocialNetwork::find()->all(),'id', 'network');
?>
<label><?=Yii::t('app','Social Network');?></label>
<?php

foreach ($networkList as $networkId => $network){
	$modelUserSocial = $modelsUserSocial[$networkId] ?? (new UserSocial);?>
		<div class="row">
			<div class="col-sm-2">
				<?= $form->field($modelUserSocial, "[{$networkId}]network_id")->hiddenInput(['value'=> $networkId])->label(false);?>
				<?= $network;?>
			</div>
			<div class="col-sm-5">
				<?= $form->field($modelUserSocial, "[{$networkId}]name")->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-sm-5">
				<?= $form->field($modelUserSocial, "[{$networkId}]link")->textInput(['maxlength' => true]) ?>
			</div>
		</div><!-- .row -->
<?php } ?>
