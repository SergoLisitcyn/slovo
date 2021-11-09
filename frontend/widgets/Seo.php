<?php

namespace frontend\widgets;
use common\models\Blog;
use common\models\MainPage;
use \yii\bootstrap\Widget;

class Seo extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $seo = MainPage::findOne(1);

        return $this->render('seo', [
            'seo' => $seo,
        ]);
    }
}