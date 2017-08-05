<?php foreach ($dataProvider->getModels() as $model){ ?>
    <?= $this->render('chat/_item', ['model' => $model]);?>
<?php } ?>