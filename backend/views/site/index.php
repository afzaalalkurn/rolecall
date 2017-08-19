<?php
use yii\grid\GridView;
use backend\modules\user\models\search\Director as DirectorSearch;
use backend\modules\user\models\search\Talent as TalentSearch;
use yii\helpers\Html;
use backend\modules\job\models\search\JobItem as ItemSearch;
/* @var $this yii\web\View */

$this->title = 'Welcome to administration';
$searchManager = new DirectorSearch();
$searchTalent = new TalentSearch();
$searchDeleteRequest = new TalentSearch();
$searchItem = new ItemSearch();

?>


<!-- Info boxes -->
<div class="row">

    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user" aria-hidden="true"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Casting Managers</span>
                <span class="info-box-number"><?=$searchManager->getCount();?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users" aria-hidden="true"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Talents</span>
                <span class="info-box-number"><?=$searchTalent->getCount();?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-list-alt" aria-hidden="true"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Gigs</span>
                <span class="info-box-number"><?=$searchItem->getCount();?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <!-- USERS LIST -->
        <?= $this->render('partial/_manager', ['searchManager'=>$searchManager])?>
    </div>
    <div class="col-md-12">
        <!-- USERS LIST -->
        <?= $this->render('partial/_talent', ['searchTalent'=>$searchTalent]);?>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <?= $this->render('partial/_job', ['searchItem'=>$searchItem])?>

    </div>
</div>

<!-- Main row -->
<div class="row">
    <div class="col-md-6">
        <?= $this->render('partial/_director_delete_request', ['searchRequest' => $searchManager])?>
    </div>
    <div class="col-md-6">
        <?= $this->render('partial/_talent_delete_request', ['searchRequest' => $searchTalent])?>
    </div>
</div>
