<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\search\UserSocial */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Socials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-social-index">

     <?= ListView::widget([
                'dataProvider' => $dataProvider, 
                'itemView' => 'partial/_item',  
                'itemOptions' => [
                                    'tag' => false,
                                 ],
                'layout' => '<div id="pagination-wrap" class="hidden">{pager}</div>{items}',
            ]); 
         ?>  
</div>
