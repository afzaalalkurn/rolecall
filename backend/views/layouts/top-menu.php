<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
$controller = $this->context;
$menus = $controller->module->menus;
$route = $controller->route;
foreach ($menus as $i => $menu) {
    $menus[$i]['active'] = strpos($route, trim($menu['url'][0], '/')) === 0;
}
$this->params['nav-items'] = $menus;
$this->params['top-menu'] = true;
$this->registerCssFile('@web/css/top-menu.css');
?>
<?php $this->beginContent($controller->module->mainLayout);?>


<div class="row">
    <div class="col-lg-12">
		<div class="list-group list-group-horizontal pull-right">
		<?php
			foreach ($menus as $menu) {
				$label = Html::tag('span', Html::encode($menu['label']), []);
				$active = $menu['active'] ? ' active' : '';
				echo Html::a($label, $menu['url'], [
					/*'class' => 'list-group-item' . $active,*/
					'class' => 'list-group-item ' . $active,
				]);
			}
			?>
		</div>

        <?= $content ?> 
    </div>
</div>
<?php $this->endContent(); ?>
