<?php

namespace frontend\widgets;
use common\models\SaleNews;
use \yii\bootstrap\Widget;

class SalesNews extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $sales = SaleNews::find()
            ->where(['status' => 1])
            ->orderBy(['date' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('sales_news', [
            'sales' => $sales,
        ]);
    }
}