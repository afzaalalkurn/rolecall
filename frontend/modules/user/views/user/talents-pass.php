<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View
 *//* @var $searchModel backend\modules\user\models\search\User
 *//* @var $dataProvider
 * yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<?php if($dataProviderPass->count > 0){?>
<div class="col-sm-9">
    <div class="user-index">
        <header class="entry-header">
            <h1 class="dashtitle"><?= Html::encode("Passed by Casting") ?></h1>
        </header><div class="productbgcolor">
            <div class="row">
                <?= ListView::widget([
                    'dataProvider' => $dataProviderPass,
                    'itemView' => 'partial/_talant',
                    'itemOptions' => [ 'tag' => false, ],
                    'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php } if($dataProviderDecline->count > 0){?>
<div class="col-sm-9">
    <div class="user-index">
        <header class="entry-header">
            <h1 class="dashtitle"><?= Html::encode("Passed by Talent") ?></h1>
        </header><div class="productbgcolor">
            <div class="row">
                <?= ListView::widget([
                    'dataProvider' => $dataProviderDecline,
                    'itemView' => 'partial/_talant',
                    'itemOptions' => [ 'tag' => false, ],
                    'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>