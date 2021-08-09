<?php
use yii\helpers\Html;
use backend\helpers\MenuToggleHelper;
/* @var $this \yii\web\View */
/* @var $content string */


backend\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);
\hiqdev\assets\icheck\iCheckAsset::register($this);
//backend\assets\TooltipsterAsset::register($this);

$user = \common\models\User::findIdentity(Yii::$app->user->id);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini <?= MenuToggleHelper::initMenuState()?>">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'header',
        [
            'directoryAsset' => $directoryAsset,
            'fullName' => $user->getUserName(),
            'avatar' => $user->getAvatar(),
        ]
    ) ?>

    <?= $this->render(
        'left',
        [
            'directoryAsset' => $directoryAsset,
            'fullName' => $user->getUserName(),
            'avatar' => $user->getAvatar(),
        ]
    )
    ?>

    <?= $this->render(
        'emptyContent',
        ['content' => $content, 'directoryAsset' => $directoryAsset]
    ) ?>

</div>

<div class="page-loader">
    <div class="preloader pls-white">
        <div class="loader"></div>
        <p>Please wait...</p>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
