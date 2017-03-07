<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use backend\modules\job\models\search\JobItem as JobItemSearch;


$searchModel = new JobItemSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->query->orderBy('job_item.job_id DESC');
$dataProvider->query->limit = 5;
$dataProvider->setPagination(false);
?>

<div class="recentjob-sect">
    <div class="container">
        <h2>Recent Jobs</h2>
        <div class="rj-slider">
            <!--slider code start   -->
            <ul id="flexiselDemo3">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_jobitem',
                    'itemOptions' => [ 'tag' => false, ],
                    'layout' => '{items}',]);
                ?>
            </ul>
            <a href="/jobs" class="ns-viewdetails">view all</a>
            <!--slider code end   -->
        </div>
    </div>
</div>