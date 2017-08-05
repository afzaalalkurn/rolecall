<div class="attachments">
    <?php foreach ($dataProvider->getModels() as $model){ ?>
        <?= $this->render('chat/_attachment', ['model' => $model]);?>
    <?php } ?>
</div>
