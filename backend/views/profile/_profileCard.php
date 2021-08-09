<?php


use common\models\User;
use yii\helpers\Url;

/**
 * @var $model User
 */
?>

<div class="col-xs-12 col-md-4 col-lg-2">
    <div class="profile-card">
        <img src="<?= $model->getAvatar();?>" alt="Profile Avatar" style="width:100%">
        <div class="body">

            <?php if ($model->profile) : ?>
                <a style="text-decoration: underline;" href="<?= Url::toRoute(['/profile/view','id' => $model->profile->id])?>">
                    <h1 class="truncate"><?= $model->getUserName()?></h1>
                </a>
            <?php else:?>
                <h1 class="truncate"><?= $model->getUserName()?></h1>
            <?php endif;?>

            <p class="title truncate"><?= $model->getPosition()?></p>
        </div>
        <p>
            <a class="contact" href="mailto:<?= $model->email;?>">Contact</a>
        </p>
    </div>
</div>