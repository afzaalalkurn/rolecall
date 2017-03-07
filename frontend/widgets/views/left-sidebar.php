<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\job\models\JobItem;
?>

<?php
$role = Yii::$app->user->identity->getRoleName();
if($role == "Director")
{
    $job_id = Yii::$app->getRequest()->getQueryParam('id');
    if(isset($job_id)){
        $JobItem = JobItem::findOne(['job_item.name','job_id' => $job_id]);
        ?>
        <span class='dashboardtab'>
        <a href="<?= Url::to(['/job/job-item/view','id' => $job_id])?>"><span><?=$JobItem->name?></span>
        <small>See Rolecall Overview</small>
            </a>
    	</span>
    <?php
        }
    ?>
<?php }
else if($role == "User")
{
    $user = Yii::$app->user->identity->userProfile;
    $name = $user->first_name .' '.$user->last_name;
    ?>
    <span class='dashboardtab'>
        <a href="<?= Url::to('/user/user/view')?>"><span><?=$name;?></span>
        <small>See Profile Overview</small>
        </a>
    </span>
<?php }
?>
<?php
if( isset($tpls) && count($tpls) > 0){
    ?>
    <?php foreach ($tpls as $key => $tpl) {?>
        <?php if( isset($tpl) && count($tpl) > 0){
            $active = '';
            $status = (Yii::$app->request->get('status')) ? Yii::$app->request->get('status') : 'Matches';
            if($status == $tpl['status'])
            {
                $active = "class = 'active-talent'";
            }
            ?>
            <li <?=$active;?>>
                <?= Html::a($tpl['title']."<span class='counter'>".$tpl['count']."</span>", $tpl['path'],
                ['class' => $tpl['class'], 'id'=>$tpl['id'],
                    'status'=>$tpl['item']
                ]);
                ?>
            </li>
        <?php } ?>
    <?php } ?>
    <?/*= ( isset( Yii::$app->user->id ) ) ? $this->render('partial/_upgradebtn', [ 'id' => Yii::$app->user->id,]) : null;*/?>
<?php } ?>