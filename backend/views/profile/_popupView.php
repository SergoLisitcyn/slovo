<?php

use common\models\UserProfile;
use common\models\User;

/**
 * @var $user User | boolean
 * @var $model UserProfile | boolean
 */

?>

<div class="row popup">
    <div class="user-header">
        <img class="img-circle" src="<?= $user ? $user->getAvatar() : UserProfile::DEFAULT_AVATAR;?>">
        <br>
        <div class="popup-row">
            <span class="capitalize bold"><?= $user ? $user->getUserName() : 'Not Set';?></span>
        </div>
        <div class="popup-row">
            <small class="bold"><?= $model ? $model->profession : "";?></small>
        </div>
            <div class="popup-row">
            <small>Member since <?= date("M Y",($user ? $user->created_at : time()));?></small>
        </div>
    </div>
</div>
