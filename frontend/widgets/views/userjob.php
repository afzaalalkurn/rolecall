<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\job\models\search\JobUserMapper as JobUserMapperSearch;


$searchModel = new JobUserMapperSearch();

$searchModel->user_id = $user_id;
$searchModel->status = 'Approved';
$dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
$dataProvider->query->orderBy('job_id DESC');
$dataProvider->query->limit = 3;
$dataProvider->setPagination(false);
?>

<div class="recent-job-postingSec">
    <h1>My Rolecalls </h1>
    <div class="row">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'partial/_userjob',
        'itemOptions' => [ 'tag' => false, ],
        'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',]);
    ?>
    </div>
    <div class="text-center"><a href="<?= (!Yii::$app->user->isGuest && Yii::$app->user->identity->isUser()) ? '/job/job-user-mapper/index?user_id='.$user_id.'&status=Approved' : '/jobs' ?>" class="btn btn-primary">View All</a></div>
</div>