<?php



use yii\helpers\Html;

use yii\widgets\DetailView;

use yii\web\JqueryAsset;

use yii\widgets\ListView;

use yii\helpers\Url;

/* @var $this yii\web\View */

/* @var $model backend\modules\user\models\UserMsg */



$this->title = Yii::t('app','Inbox');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Message'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/ajax/main.js', ['depends' => [JqueryAsset::className()]]);



?>

<header class="entry-header">

    <h1 class="dashtitle">User Message</h1>

</header>

<div class="user-school-msg-view">

    <div class="productbgcolor">

        <?= Html::a(Yii::t('app', 'Back'),   ['index'], ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'message_id' => $message_id], [

            'class' => 'btn btn-danger pull-right',

            'data' => [

                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),

                'method' => 'post',

            ],

        ]) ?>

        <?= $this->render('partial/_mailbtn', [ 'identifier' => $identifier, 'message_id' => $message_id]); ?>

    </div>



    <div class="productbgcolor mailbox">

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

</div>

<?php



$url = Url::to(['read-message']);

$js = <<<JS



$('.jobitembox').on('click', function () {



        var t =  $(this);    

        $.ajax({

            url    : '$url',

            type   : 'POST',

            data   : {message_id:$(t).attr('message_id'), seq:$(t).attr('seq')},

            success: function (response){

                console.log(response);

                if(response.success == true ){

                    $(t).removeClass('msg-UnRead').addClass('msg-Read');                    

                }

                

                return false;

            },

            error  : function (){

                console.log('internal server error');

            }

        });

        return false;

    });  



    $('.download').click(function(event){

        event.stopImmediatePropagation();

    });

JS;



$this->registerJs($js);



?>

