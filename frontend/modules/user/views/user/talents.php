<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View
 *//* @var $searchModel backend\modules\user\models\search\User
 *//* @var $dataProvider
 * yii\data\ActiveDataProvider */

if($status == "Declined"){
    $this->title = 'Passed By Talents';
} else if($status == "Passed"){
    $this->title = 'Passed By Casting';
}else {
    $this->title = $status . ' Talents';
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-sm-9">
    <div class="user-index">
        <header class="entry-header">
            <h1 class="dashtitle"><?= Html::encode($this->title) ?></h1>
        </header><div class="productbgcolor">
            <div class="row">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => 'partial/_talant',
                    'itemOptions' => [ 'tag' => false, ],
                    'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',
                ]);
                ?>
            </div>
        </div>
    </div>
</div>