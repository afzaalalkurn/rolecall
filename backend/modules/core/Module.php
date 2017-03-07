<?php
namespace backend\modules\core; 
use backend\modules\auth\components\Configs;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\core\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'core-settings';

    /**
     * @var array 
     * @see [[items]]
     */
    private $_menus = [];

    /**
     * @var array 
     * @see [[items]]
     */
    private $_moduleItems = [
        'core-plan'        => 'Membership Plans',
        'core-ads-plan'        => 'Ads Plan',
        'core-ads-position'        => 'Ads Position',
        'core-social-network'   => 'Social Links',

    ];

    /**
     * @var array 
     * @see [[items]]
     */
    private $_normalizeMenus;

    /**
     * Nav bar items
     * @var array  
     */
    public $navbar;

    /**
     * @var string Main layout using for module. Default to layout of parent module.
     * Its used when `layout` set to 'left-menu', 'right-menu' or 'top-menu'.
     */
    public $mainLayout = 'backend/modules/core/views/layouts/main.php';

    /**
     * @inheritdoc
     */

    public function init()
    {
        parent::init();

        // custom initialization code goes here

        if (!isset(\Yii::$app->i18n->translations['rbac-admin'])) {
            \Yii::$app->i18n->translations['rbac-admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => 'backend/modules/admin/messages'
            ];
        }
        //user did not define the Navbar?
        if ($this->navbar === null) {
            $this->navbar = [
                ['label' => \Yii::t('rbac-admin', 'Help'), 'url' => 'https://github.com/mdmsoft/yii2-admin/blob/master/docs/guide/basic-usage.md'],
                ['label' => \Yii::t('rbac-admin', 'Application'), 'url' => \Yii::$app->homeUrl]
            ];
        } 

    }

    /**
     * Get avalible menu.
     * @return array
     */
    public function getMenus()
    {

        if ($this->_normalizeMenus === null) {
            $mid = '/' . $this->getUniqueId() . '/';

            // resolve ads menus
            $this->_normalizeMenus = [];
            //$config = components\Configs::instance();
            $config = Configs::instance();
            foreach ($this->_moduleItems as $id => $lable) {
                if ($id !== 'menu' || ($config->db !== null && $config->db->schema->getTableSchema($config->menuTable) !== null)) {
                    $this->_normalizeMenus[$id] = ['label' => \Yii::t('rbac-admin', $lable), 'url' => [$mid . $id]];
                }
            }
            foreach (array_keys($this->controllerMap) as $id) {
                $this->_normalizeMenus[$id] = ['label' => \Yii::t('rbac-admin', Inflector::humanize($id)), 'url' => [$mid . $id]];
            }

            // user configure menus
            foreach ($this->_menus as $id => $value) {
                if (empty($value)) {
                    unset($this->_normalizeMenus[$id]);
                } else {
                    if (is_string($value)) {
                        $value = [
                            'label' => $value,
                        ];
                    }
                    $this->_normalizeMenus[$id] = isset($this->_normalizeMenus[$id]) ? array_merge($this->_normalizeMenus[$id], $value) : $value;
                    if (!isset($this->_normalizeMenus[$id]['url'])) {
                        $this->_normalizeMenus[$id]['url'] = [$mid . $id];
                    }
                }
            }
        }
        return $this->_normalizeMenus;
    }

    /**
     * Set or add avalible menu.
     * @param array $menus
     */
    public function setMenus($menus)
    {
        $this->_menus = array_merge($this->_menus, $menus);
        $this->_normalizeMenus = null;
    }
}
