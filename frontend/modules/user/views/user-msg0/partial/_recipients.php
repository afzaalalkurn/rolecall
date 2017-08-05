<?php
use yii\widgets\ListView;
?>
<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'chat/_recipient',
    'id' => 'chat-recipients',
    'layout' => '{items}',
    'itemOptions' => ['tag' => false,],
]);
?>
