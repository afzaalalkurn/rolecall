<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use frontend\widgets\FeaturedJobWidget;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile('@web/ajax/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

if(isset($dashboardBreadcrumb)){
    $this->params['breadcrumbs'][] = $dashboardBreadcrumb;
}
$this->title = 'All Rolecalls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="RoleCallfront col-sm-9">
    <header class="entry-header">
        <?php if (isset($tpls) && count($tpls) > 0) { ?>
            <?php foreach ($tpls as $key => $tpl) { ?>
                <?php if (isset($tpl) && count($tpl) > 0) { ?>
                    <?= Html::button($tpl['title'], ['value' => $tpl['path'], 'class' => $tpl['class'], 'id' => $tpl['id'], 'status' => $tpl['item']]); ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <h1 class="dashtitle"><?= Html::encode($this->title) ?></h1>
    </header>
<div class="job-item-index">
    <div class="productbgcolor">        
    <div class="row">
        <!--<div class="col-sm-12">
            <?php //echo $this->render('_search', ['model' => $searchModel, /*'modelUserFields' => $modelUserFields,*/]); ?>
            <!--<div class="feaaaturedjobs">
                <h2>Featured Jobs</h2>
                <?/*= FeaturedJobWidget::widget();*/?>
            </div>-->
        <!--</div>-->
        </div>
        <div class="row">
        <div class="col-sm-12">
            <div class="joblistingSec">
            	<div class="row">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => 'partial/_item',
                    'itemOptions' => [
                        'tag' => false,
                    ],
                    'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',
                ]);
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

