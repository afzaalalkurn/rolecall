<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\job\models\search\JobUserMapper;

$searchModel = new JobUserMapper();
$searchModel->status = "Approved";
$dataProvider = $searchModel->searchJobUser(Yii::$app->request->queryParams);
$dataProvider->query->limit = 3;
$dataProvider->setPagination(false);

?>

    <div class="recent-job-postingSec">
        <h1>Selected Talents</h1>
        <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'partial/_talent',
            'itemOptions' => [ 'tag' => false, ],
            'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',]);
        ?>
        </div>
        <div class="text-center"><a href="<?= (!Yii::$app->user->isGuest && Yii::$app->user->identity->isDirector()) ? '/job-talents?status=Approved' : '/jobs' ?>" class="btn btn-primary">View All</a></div>
    </div>