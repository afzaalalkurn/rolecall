<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Inflector;
use backend\widgets\Alert;
?>
<aside class="right-side">
    <section class="content-header">
        <h1>
            <?php
            /*if ($this->title !== null) {
                echo $this->title;
            } else {
                echo Inflector::camel2words(Inflector::id2camel($this->context->module->id));
                echo ($this->context->module->id !== Yii::$app->id) ? '<small>Module</small>' : '';
            }*/ ?>
        </h1>
        <?=
        Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
        
    </section>

    <section class="content">
        <?php Alert::widget() ?>
        <?= $content ?>
    </section>


</aside>