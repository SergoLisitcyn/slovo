<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use karpoff\icrop\CropImageUpload;
use yii\bootstrap\ActiveForm;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Профиль";
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
                                <a href="#" class="pmop-edit" data-toggle="modal" data-target="#avatar-modal">
                                    <i class="fa fa-camera"></i>
                                    <span class="hidden-xs">Обновить аватар</span>
                                </a>
                            </div>
                            <div class="pmo-stat">
                                <h2 class="m-0"><?= $model ? $model->full_name ? $model->full_name: $user->username : $user->username;?></h2>
                                <?= $model ? $model->profession : "";?>
                            </div>
                        </div>
                        <div class="pmo-block pmo-contact hidden-xs">
                            <h2>Контакты</h2>
                            <ul>
                                <li><i class="fa fa-envelope-o"></i> <?= $user->email;?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 pf-body">
                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="fa fa-signal m-r-10"></i> О себе</h2>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-box-tool dropdown-toggle edit-button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" style="vertical-align: super;"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="update-btn-summary">Редактировать</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view" id="summary-text" <?= ($model && $model->about_me) ? "": "style='display:none;'"?>>
                                    <?= ($model && $model->about_me) ? $model->about_me : 'Добавьте несколько слов о себе ...'?>
                                </div>

                                <div class="pmbb-edit" id="summary-form" <?= ($model && $model->about_me) ? "": "style='display:block;'"?>>
                                    <div class="fg-line">
                                        <textarea class="form-control" id="summary" rows="5" placeholder="Добавьте несколько слов о себе ..."><?= ($model && $model->about_me) ? $model->about_me : ''?></textarea>
                                    </div>
                                    <div class="m-t-10">
                                        <button class="btn btn-default btn-sm" onclick="saveSummary();">Сохранить</button>
                                        <button data-ma-action="summary-edit-cancel" class="btn btn-link btn-sm">Отменить</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="fa fa-user m-r-10"></i> Основная информация</h2>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-box-tool dropdown-toggle edit-button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" style="vertical-align: super;"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="update-btn-basic">Редактировать</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view" id="basic-text">
                                    <dl class="dl-horizontal">
                                        <dt>Полное имя</dt>
                                        <dd class="fullName"><?= ($model && $model->full_name) ? $model->full_name : "<span class='not-set'>(Не указана)</span>"?></dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Должность</dt>
                                        <dd class="position"><?= ($model && $model->profession) ? $model->profession : "<span class='not-set'>(Не указана)</span>"?></dd>
                                    </dl>
                                </div>

                                <div class="pmbb-edit" id="basic-form">
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Полное имя</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="text" id="fullName" class="form-control" placeholder="например Иван Иванов" value="<?= ($model && $model->full_name) ? $model->full_name: "";?>">
                                            </div>

                                        </dd>
                                    </dl>

                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Должность</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="text" name="position" id="position" class="form-control" placeholder="например Менеджер" value="<?= (($model && $model->profession) ? $model->profession: "") ?>">
                                            </div>
                                        </dd>
                                    </dl>

                                    <div class="m-t-30">
                                        <button class="btn btn-default btn-sm" onclick="saveBasicInfo();">Сохранить</button>
                                        <button data-ma-action="basic-edit-cancel" class="btn btn-link btn-sm">Отмена</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>

<!-- Modal -->
<div id="avatar-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Обновить аватар</h4>
            </div>
            <?php $form = ActiveForm::begin(["action" => ["upload"], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="modal-body">
                    <?php if ($model) {?>
                        <?= $form->field($model, 'avatar')->widget(CropImageUpload::className())->label(false) ?>
                    <?php }?>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-check"></i> Загрузить', ['class' => 'mbtn mbtn-primary']) ?>
                        <button type="button" class="mbtn mbtn-gray" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(
    '@web/js/profile.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
