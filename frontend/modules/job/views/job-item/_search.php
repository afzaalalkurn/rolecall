<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\job\models\JobCategory;
use backend\modules\user\models\search\UserProfile;

/* @var $this yii\web\View */
/* @var $model backend\modules\job\models\search\JobItem */
/* @var $form yii\widgets\ActiveForm */
$modelProfile = new UserProfile();

?>
<div class="job-item-search">
    <?php
    $form = ActiveForm::begin([
        'action' => ['/job/job-item/index'],
        'method' => 'GET'
    ]);
    ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="search-item-box">
                <h2>Refine Search</h2>
                <div class="formdiv">
                    <div class="row">
                        <div class="col-sm-5">
                            <?= $form->field($modelProfile, 'first_name')
                                ->textInput(array('placeholder' => Yii::t('job', 'Search By Rolecall Name')))->label(false) ?>
                        </div>
                        <div class="col-sm-5">
                            <?= $form->field($modelProfile, 'about_us')
                                ->textInput(array('placeholder' => Yii::t('job', 'Search By Role Details')))->label(false) ?>
                        </div>
                        <div class="col-sm-2">
                            <?=$this->render('partial/_searchable', [
                                'form'           => $form,
                            ]);?>
                            <div class="form-group submit">
                                <?= Html::submitButton(Yii::t('job', 'Search'),
                                    ['class' => 'btn btn-primary']) ?>
                                <? //= Html::a(Yii::t('job', 'Reset'),['job-item/index'], ['class' => 'btn btn-primary']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
