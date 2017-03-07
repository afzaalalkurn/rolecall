<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\job\models\search\JobFieldValue */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Other Requirements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-field-value-index">

    <h3><?= Html::encode($this->title) ?></h3>
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
