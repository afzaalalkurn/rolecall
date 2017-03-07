<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use backend\modules\job\models\search\JobItem as JobItemSearch;


$searchModel = new JobItemSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->query->where('is_featured= 1')->orderBy('job_item.job_id DESC');
$dataProvider->query->limit = 2;
$dataProvider->setPagination(false);
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'partial/_featured',
    'itemOptions' => [ 'tag' => false, ],
    'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',]);
?>