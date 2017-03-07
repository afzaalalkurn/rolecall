<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobUserMapper */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->title = Yii::t('app', sprintf('%s Jobs',$searchModel->status));

$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['/dashboard']];
if($searchModel->status == "Passed") {
    $this->title = Yii::t('app', sprintf('%s By Casting Director', $searchModel->status));
} else {
    $this->title = Yii::t('app', sprintf('%s By Talent', $searchModel->status));
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-sm-9">
<div class="job-user-mapper-index">
<header class="entry-header">
<h1 class="dashtitle"><?= Html::encode($this->title) ?></h1>
</header>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="productbgcolor">
    <div class="row">
     <?= ListView::widget([
                'dataProvider' => $dataProvider, 
                'itemView' => 'partial/_item',  
                'itemOptions' => ['tag' => false,],
                'layout' => '<div id="pagination-wrap" class="hidden">{pager}</div>{items}',
            ]); 
         ?>   
    </div> 
    </div>    
</div>
</div>