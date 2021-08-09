<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use karpoff\icrop\CropImageUpload;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Profile";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-10 col-lg-offset-1">
            <div class="col-lg-12 card">

                <div class="col-lg-3 pf-overview">
                    <div class="pf-pic">
                        <div class="p-relative">
                            <a href="#!">
                                <?php if ($model->isNewRecord || !is_file(\Yii::$app->basePath."/web/images/avatars/".$model->avatar_cropped)) {?>
                                    <img class="img-responsive" src="/admin/images/user-placeholder.jpg">
                                <?php } else {?>
                                    <img class="img-responsive" src="<?="/admin/images/avatars/".$model->avatar_cropped?>">
                                <?php }?>
                            </a>

                        </div>
                        <div class="pmo-stat">
                            <h2 class="m-0"><?= $model ? $model->full_name ? $model->full_name: $user->username : $user->username;?></h2>
                            <?= $model ? $model->profession : "";?>
                        </div>
                    </div>
                    <div class="pmo-block pmo-contact hidden-xs">
                        <h2>Contact</h2>
                        <ul>
                            <li><i class="fa fa-phone"></i> <?= ($model && $model->phone) ? $model->phone: "<span class='not-set'>(Not Set)</span>";?></li>
                            <li><i class="fa fa-envelope-o"></i> <?= ($model && $model->public_email) ? $model->public_email : $user->email;?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 pf-body">
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="fa fa-signal m-r-10"></i> Summary</h2>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view" id="summary-text">
                                <?= ($model && $model->about_me) ? $model->about_me : '<span class=\'not-set\'>(Not Set)</span>'?>
                            </div>
                        </div>
                    </div>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="fa fa-user m-r-10"></i> Basic Information</h2>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view" id="basic-text">
                                <dl class="dl-horizontal">
                                    <dt>Full Name</dt>
                                    <dd class="fullName"><?= ($model && $model->full_name) ? $model->full_name : "<span class='not-set'>(Not Set)</span>"?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Position</dt>
                                    <dd class="position"><?= ($model && $model->profession) ? $model->profession : "<span class='not-set'>(Not Set)</span>"?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="pmb-block" style="padding-bottom: 30px;">
                        <div class="pmbb-header">
                            <h2><i class="fa fa-phone m-r-10"></i> Contact Information</h2>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view" id="contact-text">
                                <dl class="dl-horizontal">
                                    <dt>Mobile Phone</dt>
                                    <dd class="phone"><?= ($model && $model->phone) ? $model->phone : "<span class='not-set'>(Not Set)</span>"?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
