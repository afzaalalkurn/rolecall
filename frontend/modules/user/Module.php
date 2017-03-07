<?php

namespace frontend\modules\user;
use Yii;
/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if (!isset(Yii::$app->i18n->translations['job'])) {

            Yii::$app->i18n->translations['job'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => 'frontend/modules/messages'
            ];
        } 

        //user did not define the Navbar?
        /*if ($this->navbar === null) {
            $this->navbar = [
                ['label' => Yii::t('app', 'Help'), 'url' => 'https://github.com/mdmsoft/yii2-admin/blob/master/docs/guide/basic-usage.md'],
                ['label' => Yii::t('app', 'Application'), 'url' => Yii::$app->homeUrl]
            ];
        }*/
    }
}
