<?php
use yii\helpers\Html;
?>
<div class="hw-sect">
    <div class="container blue-sect">
        <h1>How it Works</h1>
        <div class="hw-flow">
            <div class="col-md-4 col-sm-4 col-xs-12 hw-three hw-threefirst pe-animation-maybe" data-animation="fadeInDown">
                <div class="hw-circle">
                    <?=Html::img('@web/images/create-acc.png',['alt' => "Create a Account"]);?>
                </div>
                <span>Create an account</span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 hw-three hw-threesecond pe-animation-maybe" data-animation="fadeInDown">
                <div class="hw-circle">
                    <?=Html::img('@web/images/search-job.png',['alt' => "Search Job"]);?>

                </div>
                <span>Search your desired job and Apply</span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 hw-three hw-threelast pe-animation-maybe" data-animation="fadeInDown">
                <div class="hw-circle">
                    <?=Html::img('@web/images/get-hired.png',['alt' => "Get Hired"]);?>

                </div>
                <span>Get hirred</span>
            </div>
        </div>
    </div>
</div>