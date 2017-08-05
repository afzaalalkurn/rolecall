<?php



use yii\helpers\Html;

use yii\grid\GridView;

use yii\widgets\ListView;

use yii\web\JqueryAsset;



/* @var $this yii\web\View */

/* @var $searchModel backend\modules\job\models\search\JobUserMapper */

/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;

if($dataProviderPass->count > 0){
?>

<div class="col-sm-9">

    <div class="job-user-mapper-index">

        <header class="entry-header">

            <h1 class="dashtitle">Passed by Casting</h1>

        </header>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="productbgcolor">

            <div class="row">

                <?= ListView::widget([

                    'dataProvider' => $dataProviderPass,

                    'itemView' => 'partial/_item',

                    'itemOptions' => ['tag' => false,],

                    'layout' => '<div id="pagination-wrap" class="hidden">{pager}</div>{items}',

                ]);

                ?>

            </div>

        </div>

    </div>

</div>
<?php }
if($dataProviderDecline->count > 0){
    ?>
    <div class="col-sm-9">

        <div class="job-user-mapper-index">

            <header class="entry-header">

                <h1 class="dashtitle">Passed by Talent</h1>

            </header>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="productbgcolor">

                <div class="row">

                    <?= ListView::widget([

                        'dataProvider' => $dataProviderDecline,

                        'itemView' => 'partial/_item',

                        'itemOptions' => ['tag' => false,],

                        'layout' => '<div id="pagination-wrap" class="hidden">{pager}</div>{items}',

                    ]);

                    ?>

                </div>

            </div>

        </div>

    </div>
    <?php
}
?>