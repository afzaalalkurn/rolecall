<div class="user-social-index">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'partial/_social',
        'itemOptions' => [
            'tag' => false,
        ],
        'layout' => '<div id="pagination-wrap" class="hidden">{pager}</div>{items}',
    ]);
    ?>
</div>
