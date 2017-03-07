<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\UserTransaction as UserTransactionModel;
use common\models\User;
use backend\modules\core\models\search\CorePlan;

/**
 * UserTransaction represents the model behind the search form about `backend\modules\user\models\UserTransaction`.
 */
class UserTransaction extends UserTransactionModel
{

    public $method;
    public $type;
    public $number;
    public $expire_month;
    public $expire_year;
    public $cvv2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id','first_name', 'last_name', 'email', 'method'], 'required'],
            [['type', 'number', 'expire_month', 'expire_year', 'cvv2'], 'required',  'when' => function($model) {
                return $model->method == 2;
            }, 'whenClient' => 'function() {
                return $("#usertransaction-method").val() == 2;
            }'],
            [['user_id', 'plan_id', 'method', 'created_at', 'updated_at'], 'integer'],

            [['first_name', 'last_name', 'email', 'type'], 'string', 'max' => 100],

            [['number', 'expire_month', 'expire_year', 'cvv2', 'expire_month', 'expire_year'], 'integer', 'when' => function($model) {
                return $model->method == 2;
            }, 'whenClient' => 'function() {
                return $("#usertransaction-method").val() == 2;
            }'],

            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => CorePlan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

}
