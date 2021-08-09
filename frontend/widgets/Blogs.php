<?php

namespace frontend\widgets;
use common\models\Blog;
use \yii\bootstrap\Widget;

class Blogs extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $blogs = Blog::find()
            ->where(['status' => 1])
            ->orderBy(['date' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('blog', [
            'blogs' => $blogs,
        ]);
    }
}