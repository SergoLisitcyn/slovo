<?php

namespace frontend\widgets;

use common\models\Reviews;
use yii\bootstrap\Widget;
use yii\db\Expression;

class Review  extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $reviews = Reviews::find()
            ->where(['status' => 1])
            ->orderBy(new Expression('rand()'))
            ->limit(3)
            ->all();

        return $this->render('reviews', [
            'reviews' => $reviews,
        ]);
    }
}