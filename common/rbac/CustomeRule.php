<?php
namespace common\rbac;

use backend\modules\core\models\CorePlan;
use yii;
use yii\rbac\Rule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\user\models\User as User;

class CustomeRule extends Rule
{

    public $name = 'isOwner';

    /**
     *
     * @param string|integer $user
     *            the user ID.
     * @param Item $item
     *            the role or permission that this rule is associated with
     * @param array $params
     *            parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {

        if(Yii::$app->id == 'app-backend') return true;

        if (isset($params['model'])) { // Directly specify the model you plan to use via param
            $model = $params['model'];
        } else {
            // Use the controller findModel method to get the model - this is what executes via the behaviour/rules

            $id = Yii::$app->request->get('id');
            $model =  ( !empty($id) ) ? Yii::$app->controller->findModel($id) : null;

            if( isset($item->ruleName) && !empty($item->ruleName)){
                $this->{$item->ruleName}($user, $item, $params, $model);
            }
        }
    }

    public function maxJobsBaseOnPlan($user, $item, $params, $model = null){

        if (Yii::$app->user->isGuest) {
            throw new yii\web\NotAcceptableHttpException('Please Login, Your are not allow to create job.');
        }
        $jobs    = Yii::$app->user->identity->getJobItems()->count();

        //$plan_id = Yii::$app->user->identity->userSchool->plan_id;

        //$plan = CorePlan::findOne(['id'=>$plan_id]);

        /*if( $plan && $jobs >= $plan->jobs ){
            throw new yii\web\NotAcceptableHttpException('Your are not allow to process, Please Upgrade your membership plan.');

        }*/
    }

    public function isAllow($user, $item, $params, $model){

        if( ($model instanceof User && $model->id == $user) || ($model->user_id == $user)){
            return true;
        }else{
            throw new yii\web\NotAcceptableHttpException('you are not allow to process this access.');
        }
    }
}
