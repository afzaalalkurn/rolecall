<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 11/7/16
 * Time: 10:52 AM
 */

namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;


class Model extends yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [], $fld = 'id')
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, $fld, $fld));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item[$fld]) && !empty($item[$fld]) && isset($multipleModels[$item[$fld]])) {
                    $models[] = $multipleModels[$item[$fld]];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
}
