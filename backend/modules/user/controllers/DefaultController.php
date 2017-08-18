<?php

namespace backend\modules\user\controllers;

use yii\web\Controller;

use backend\modules\job\models\search\JobItem as JobItemSearch;
use backend\modules\user\models\search\Talent as TalentSearch ;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImportData()
    {
        //$talent = new TalentSearch();
        //$talent->importData();

        $job = new JobItemSearch();
        $job->importData();
    }

}
