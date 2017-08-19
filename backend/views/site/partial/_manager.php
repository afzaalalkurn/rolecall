<?php
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 19/6/17
 * Time: 10:25 AM
 */
?>
<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Latest Directors</h3>
        <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php
        $dataProvider = $searchManager->search(Yii::$app->request->queryParams);
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Name',
                    'attribute' =>'userProfile.name',
                ],
                'email:email',

                /*[
                    'attribute' => 'userProfile.is_verified',
                    'value' => function ($model) {
                        $status = '';
                        switch($model->userProfile->is_verified){
                            case 0:
                                $status = 'Unverified';
                                break;
                            case 1:
                                $status = 'Pending';
                                break;
                            case 2:
                                $status = 'Verified';
                                break;
                            case 3:
                                $status = 'Insufficient';
                                break;
                        }
                        return  $model->status == 10 ? 'Active ' . '( '.$status.' )' : 'Blocked';
                    },
                ],*/
                [
                    'label' => 'Registration Date',
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return  date('j F, Y H:i: A',$model->created_at);
                    },
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = '/admin/user/manager/view?id='.$model->id;
                            return $url;
                        }
                    },

                ],
            ],
        ]); ?>
        <!-- /.users-list -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer text-center">
        <?=Html::a( 'View all casting managers', ['/user/manager/index'], ['class' => 'btn btn-sm btn-default btn-flat pull-right uppercase']);?>
    </div>
    <!-- /.box-footer -->
</div>
<!--/.box -->
