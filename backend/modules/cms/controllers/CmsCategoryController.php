<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsCategory;
use backend\modules\cms\models\CmsCategoryPath as CmsCategoryPath;
use backend\modules\cms\models\search\CmsCategory as CmsCategorySearch;
use backend\modules\cms\models\search\CmsCategoryPath as CmsCategoryPathSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsCategoryController implements the CRUD actions for CmsCategory model.
 */
class CmsCategoryController extends Controller
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
     * Lists all CmsCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsCategory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRepair(){
        $searchModel = new CmsCategorySearch();
        $searchModel->repair();
        exit;
    }

    /**
     * Creates a new CmsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsCategory();

        if ($model->load(Yii::$app->request->post())) {

            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();

            if($model->save()){

                $query = ( new CmsCategoryPathSearch)->getItemPath($model->parent_id);
                $level = 0;

                if ($query->count() > 0) {

                    foreach ($query->all() as $result) {

                        $modelPath = new CmsCategoryPath;
                        $modelPath->category_id = (int) $model->category_id;
                        $modelPath->parent_id = (int) $result->parent_id;
                        $modelPath->level = (int) $level;

                        if (!$modelPath->save()) {
                            throw Exception('Unable to save record.');
                        }
                        $level++;
                    }
                }

                $modelPath = new CmsCategoryPath;
                $modelPath->level = (int) $level;
                $modelPath->parent_id = (int) $model->category_id;
                $modelPath->category_id = (int) $model->category_id;

                if ($modelPath->save()) {
                    $transaction->commit();
                } else {
                    throw Exception('Unable to save record.');
                }
            }

            return $this->redirect(['view', 'id' => $model->category_id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelCmsCategoryPath = $model->cmsCategoryPaths;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            /*                     **************** Path start ********* */

            // MySQL Hierarchical Data Closure Table Pattern
            $query = ( new CmsCategoryPathSearch)->getItemPathLevel($id);

            if ($query->count() > 0) {

                foreach ($query->all() as $result) {
                    $modelPath = new CmsCategoryPath;
                    $modelPath::deleteAll('category_id = :category_id AND level < :level', [':level' => $result->level, ':category_id' => $result->category_id]);

                    $path = array();
                    $query2 = ( new CmsCategoryPathSearch)->getItemPath($model->parent_id);
                    foreach ($query2->all() as $result2) {
                        $path[] = $result2->parent_id;
                    }
                    $query3 = ( new CmsCategoryPathSearch)->getItemPath($result->category_id);
                    foreach ($query3->all() as $result3) {
                        $path[] = $result3->parent_id;
                    }
                    $level = 0;
                    foreach ($path as $parent_id) {

                        $modelPath = CmsCategoryPath::findOne([
                                'category_id' => (int) $result->category_id,
                                'parent_id' => $parent_id]) ?? ( new CmsCategoryPath );

                        $modelPath->category_id = (int) $result->category_id;
                        $modelPath->parent_id = (int) $parent_id;
                        $modelPath->level = (int) $level;

                        if (!$modelPath->save()) {
                            throw Exception('Unable to save record.');
                        }
                        $level++;
                    }
                }
            } else {

                $modelPath = new CmsCategoryPath;

                // Delete the path below the current one
                $modelPath::deleteAll('category_id = :category_id', [':category_id' => $model->category_id]);
                // Fix for records with no paths

                $query = ( new CmsCategoryPathSearch)->getItemPath($model->parent_id);
                $level = 0;

                if ($query->count() > 0) {

                    foreach ($query->all() as $result) {

                        $modelPath = new CmsCategoryPath;
                        $modelPath->category_id = (int) $model->category_id;
                        $modelPath->parent_id = (int) $result->parent_id;
                        $modelPath->level = (int) $level;

                        if (!$modelPath->save()) {
                            throw Exception('Unable to save record.');
                        }
                        $level++;
                    }
                }

                $modelPath = new CmsCategoryPath;
                $modelPath->level = (int) $level;
                $modelPath->parent_id = (int) $model->category_id;
                $modelPath->category_id = (int) $model->category_id;

                if ($modelPath->save()) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    throw Exception('Unable to save record.');
                }
            }

            /*                     * *************** Path end ********* */
            return $this->redirect(['view', 'id' => $model->category_id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CmsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
