<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\job\models\JobItem;
$searchModel = new JobItemSearch();
$searchModel->user_id = $user_id;
$currentDate = date('Y-m-d H:i:s');
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
/*$dataProvider->query->andWhere(['!=', 'job_item.job_id', $job_id])->orderBy('job_item.job_id DESC');*/
$dataProvider->query->andFilterWhere(['>', 'job_item.expire_date', $currentDate]);
$dataProvider->query->orderBy('job_item.job_id DESC');
//$dataProvider->query->limit = 4;
$dataProvider->setPagination(false);
?>

<div class="recent-job-postingSec">
    <h1>My Rolecalls </h1>
    <div class="row">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'partial/_recentjob',
        'itemOptions' => [ 'tag' => false, ],
        'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',]);
    ?>
    </div>
    <!--<div class="text-center"><a href="<?= (!Yii::$app->user->isGuest && Yii::$app->user->identity->isDirector()) ? '/my-jobs' : '/jobs' ?>" class="btn btn-primary">View All</a></div>-->
</div>