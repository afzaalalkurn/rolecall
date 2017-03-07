<?php
namespace frontend\modules\job;
use Yii;
/**
 * job module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\job\controllers';

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
    }
}
