<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\CmsMenu;
use backend\modules\cms\models\search\CmsMenu as CmsMenuSearch;
use backend\modules\cms\models\CmsMenuPath;
use backend\modules\cms\models\search\CmsMenuPath as CmsMenuPathSearch;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Json;

/**
 * CmsMenuController implements the CRUD actions for CmsMenu model.
 */
class CmsMenuController extends Controller
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
     * Lists all CmsMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsMenu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRepair(){
        $searchModel = new CmsMenuSearch();
        $searchModel->repair();
        exit;
    }

    /**
     * Creates a new CmsMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsMenu();

        if ($model->load(Yii::$app->request->post())) {

            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();

            if($model->save()){

                $query = ( new CmsMenuPathSearch)->getItemPath($model->parent_id);
                $level = 0;

                if ($query->count() > 0) {

                    foreach ($query->all() as $result) {

                        $modelPath = new CmsMenuPath;
                        $modelPath->menu_id = (int) $model->menu_id;
                        $modelPath->parent_id = (int) $result->parent_id;
                        $modelPath->level = (int) $level;

                        if (!$modelPath->save()) {
                            throw Exception('Unable to save record.');
                        }
                        $level++;
                    }
                }

                $modelPath = new CmsMenuPath;
                $modelPath->level = (int) $level;
                $modelPath->parent_id = (int) $model->menu_id;
                $modelPath->menu_id = (int) $model->menu_id;

                if ($modelPath->save()) {
                    $transaction->commit();
                } else {
                    throw Exception('Unable to save record.');
                }
            }

            return $this->redirect(['view', 'id' => $model->menu_id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelCmsMenuPath = $model->cmsMenuPaths;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            /*                     **************** Path start ********* */

            // MySQL Hierarchical Data Closure Table Pattern
            $query = ( new CmsMenuPathSearch)->getItemPathLevel($id);

            if ($query->count() > 0) {

                foreach ($query->all() as $result) {
                    $modelPath = new CmsMenuPath;
                    $modelPath::deleteAll('menu_id = :menu_id AND level < :level', [':level' => $result->level, ':menu_id' => $result->menu_id]);

                    $path = array();
                    $query2 = ( new CmsMenuPathSearch)->getItemPath($model->parent_id);
                    foreach ($query2->all() as $result2) {
                        $path[] = $result2->parent_id;
                    }
                    $query3 = ( new CmsMenuPathSearch)->getItemPath($result->menu_id);
                    foreach ($query3->all() as $result3) {
                        $path[] = $result3->parent_id;
                    }
                    $level = 0;
                    foreach ($path as $parent_id) {

                        $modelPath = CmsMenuPath::findOne([
                                'menu_id' => (int) $result->menu_id,
                                'parent_id' => $parent_id]) ?? ( new CmsMenuPath );

                        $modelPath->menu_id = (int) $result->menu_id;
                        $modelPath->parent_id = (int) $parent_id;
                        $modelPath->level = (int) $level;

                        if (!$modelPath->save()) {
                            throw Exception('Unable to save record.');
                        }
                        $level++;
                    }
                }
            } else {

                $modelPath = new CmsMenuPath;

                // Delete the path below the current one
                $modelPath::deleteAll('menu_id = :menu_id', [':menu_id' => $model->menu_id]);
                // Fix for records with no paths

                $query = ( new CmsMenuPathSearch)->getItemPath($model->parent_id);
                $level = 0;

                if ($query->count() > 0) {

                    foreach ($query->all() as $result) {

                        $modelPath = new CmsMenuPath;
                        $modelPath->menu_id = (int) $model->menu_id;
                        $modelPath->parent_id = (int) $result->parent_id;
                        $modelPath->level = (int) $level;

                        if (!$modelPath->save()) {
                            throw Exception('Unable to save record.');
                        }
                        $level++;
                    }
                }

                $modelPath = new CmsMenuPath;
                $modelPath->level = (int) $level;
                $modelPath->parent_id = (int) $model->menu_id;
                $modelPath->menu_id = (int) $model->menu_id;

                if ($modelPath->save()) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    throw Exception('Unable to save record.');
                }
            }

            /*                     * *************** Path end ********* */
            return $this->redirect(['view', 'id' => $model->menu_id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function findModel($id)
    {
        if (($model = CmsMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMenuList($q = null, $id = null) {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $model = new CmsMenuPathSearch();
        if (!is_null($q)) {
            $data = $model->getCategories(['name'=>$q])->createCommand()->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => CmsMenu::find($id)->name];
        }
        return $out;
    }

}
