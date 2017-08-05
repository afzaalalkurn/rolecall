<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 23/6/16
 * Time: 4:51 PM
 */

$url = ($model->category == "Notification") ? '/user/user-msg' : '#';
?>
<li message_id="<?=$model->message_id;?>">
    <a href="<?=$url?>">
        <i class="fa fa-users text-aqua"></i> <?=$model->text;?>
    </a>
</li>
