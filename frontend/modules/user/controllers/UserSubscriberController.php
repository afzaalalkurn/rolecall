<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use backend\modules\user\models\UserSubscriber;
use backend\modules\user\models\search\UserSubscriber as UserSubscriberSearch;

/**
 * UserSubscriberController implements the CRUD actions for UserSubscriber model.
 */
class UserSubscriberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Creates a new UserSubscriber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserSubscriber();

        $success = false;
        $msg = 'There was an error, please try again later.';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $success = true;
            $msg = 'Thank you for subscription for newsletter.';
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $success, 'msg' => $msg];

    }

    public function actionValidation(){
        $model = new UserSubscriber();
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
    /**
     * Finds the UserSubscriber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserSubscriber the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserSubscriber::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
