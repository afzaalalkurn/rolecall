<?php
use yii\grid\GridView;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 19/6/17
 * Time: 10:29 AM
 */
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Latest Gigs</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <?php
            $dataProvider = $searchItem->search(Yii::$app->request->queryParams);
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Name',
                        'attribute' =>'user.userProfile.name',
                    ],
                    'user.email:email',
                    'name',
                    [
                        'label' => 'Featured Job',
                        'attribute' => 'is_featured',
                        'value' => function ($model) {
                            return  $model->is_featured == 1 ? 'Yes' : 'No';
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = '/admin/job/job-item/view?job_id='.$model->job_id;
                                return $url;
                            }
                        },

                    ],
                ],
            ]); ?>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        <!--a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a -->
        <?=Html::a( 'View all gigs', ['/item/item/index'], ['class' => 'btn btn-sm btn-default btn-flat pull-right uppercase']);?>
    </div>
    <!-- /.box-footer -->
</div>
