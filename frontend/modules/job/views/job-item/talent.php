<?php

use yii\helpers\Html;

use yii\widgets\DetailView;

use yii\widgets\ListView;

use yii\helpers\Url;

use yii\bootstrap\Modal;

use yii\web\JqueryAsset;

use himiklab\thumbnail\EasyThumbnailImage;

use frontend\widgets\JobWidget;

use frontend\widgets\NewsWidget;



use backend\modules\user\models\UserFieldValue;

use backend\modules\user\models\UserField;



/* @var $this yii\web\View */

/* @var $model backend\modules\job\models\JobItem */

$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);



$this->title = $model->name;

/*$this->params['breadcrumbs'][] = [

    'label' => 'Job Items',

    'url' => [

        'index'

    ]

];*/

$this->params['breadcrumbs'][] = $this->title;

//pr($dataProvider->query);

?>



<div class="col-sm-9">

<div class="findtalent">

<header class="entry-header">

<h1 class="dashtitle">Select Talents<? //= Html::encode($this->title) ?></h1>

</header>



<!--<div class="taldiscription"><?php echo $model->description; ?></div>-->



<div class="productbgcolor">

        <!--<div class="row">

        <div class="col-sm-12">

            <?php //echo $this->render('_search', ['model' => $searchModel, 'modelUserFields' => $modelUserFields,]); ?>

        </div>

        </div>-->

        

        <div class="row"><div class="col-sm-12"><div id="msg"></div></div></div>

        <?php if($dataProvider->query->count() > 0){ ?>

        <!--<h3 class="dashtitle">Select Talent(s)</h3>-->

        <div class="row">

            <?= ListView::widget([

                'dataProvider' => $dataProvider,

                'itemView' => 'partial/_talent',

                'itemOptions' => [

                    'tag' => false,

                ],

                'layout' => '<div id="pagination-wrap" class="hidden">{sorter}\n{pager}</div>{items}',

            ]);?>

        </div>

    <?php }else{
            echo "No results found.";
        } ?>

</div>

</div>

</div>

<?php

$js = <<<JS



    $('#SendMessage').on('click',function(){

        $('#modelContent').load($(this).attr('value'));

    }); 

    

JS;



$this->registerJs($js);